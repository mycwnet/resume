<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Form\Type\ProfileType;
use App\Entity\ProjectHistory;
use App\Entity\Proficiencies;
use App\Entity\Configuration;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;
use App\Service\FileUploader;
use Symfony\Component\Filesystem\Filesystem;

class ProfileController extends AbstractController {

    protected $entity_manager;
    protected $profile;
    protected $user;
    protected $current_avatar;
    protected $current_background;

    private function getEntityManager() {
        if (null === $this->entity_manager) {
            $this->entity_manager = $this->getDoctrine()->getManager();
        }

        return $this->entity_manager;
    }

    private function getProfile() {
        $user = $this->getUser();
        $filesystem = new Filesystem();

        if (null === $this->profile) {
            $this->profile = $this->getEntityManager()
                    ->getRepository('App:Profile')
                    ->findOneBy(['user_id' => $user->getId()]);
            if ($this->profile->getImage() && $filesystem->exists($this->profile->getImage())) {
                $this->profile->setImage(new File($this->profile->getImage()));
            }
        }
        $this->current_avatar = $this->profile->getImage();
        return $this->profile;
    }

    /**
     * Matches /profile exactly
     *
     * @Route("/profile", name="resume_profile")
     */
    public function new(Request $request) {

        $backgroud_exists = null;
        $avatar_exists = null;
        $filesystem = new Filesystem();
        $user = $this->getUser();

        if ($user->getId()) {
            $profile = $this->getProfile();
            $profile->setImage($this->current_avatar);
            $this->loadHistories();
            $this->loadProficiencies();
            $this->loadConfiguration();
            $backgroud_exists = $this->current_background && $filesystem->exists($this->getParameter('images_directory') . '/' . $this->current_background->getBasename()) ? $this->current_background->getBasename() : null;
            $avatar_exists = $this->current_avatar && $filesystem->exists($this->getParameter('images_directory') . '/' . $this->current_avatar->getBasename()) ? $this->current_avatar->getBasename() : null;
        } else {
            $profile = new Profile();
            $profile->setUserId($user);
            $project_history = new ProjectHistory();
            $proficiency = new Proficiencies();
            $profile->addProjectHistory($project_history);
            $profile->addProficiency($proficiency);
        }

        $form = $this->createForm(ProfileType::class, $profile);

        $form->handleRequest($request);
        
        

        if ($form->isSubmitted() && $form->isValid()) {
            $avatar = $form->get('image')->getData();
                    
            if ($avatar) {
                $avatar_uploader = new FileUploader('images_directory', $this->current_avatar->getBasename());
                $avatar_filename = $avatar_uploader->upload($avatar);
                $avatar_exists=$avatar_filename;
                $profile->setImage(new File($this->getParameter('images_directory') . '/'. $avatar_filename));
            }
            
            $background = $form->get('configuration')->get('background_image')->getData();
            if ($background) {
                $background_uploader = new FileUploader('images_directory', $this->current_background->getBasename());
                $background_filename = $background_uploader->upload($background);
                $backgroud_exists=$background_filename;
                $profile->getConfiguration()->setBackgroundImage(new File($this->getParameter('images_directory') . '/' . $background_filename));
            }

            $this->getEntityManager()->persist($profile);
            $this->getEntityManager()->flush();
        }


        return $this->render('profile/profile.html.twig', [
                    'form' => $form->createView(),
                    'avatar_exists' => $avatar_exists,
                    'background_exists' => $backgroud_exists
        ]);
    }

    private function loadHistories() {
        $project_histories = $this->getEntityManager()->getRepository('App:ProjectHistory')->findAll();
        if (count($project_histories) > 0) {
            foreach ($project_histories as $project_history) {
                $this->profile->addProjectHistory($project_history);
            }
        } else {
            $project_history = new ProjectHistory();
            $this->profile->addProjectHistory($project_history);
        }
    }

    private function loadProficiencies() {
        $proficiencies = $this->getEntityManager()->getRepository('App:Proficiencies')->findAll();
        if (count($proficiencies) > 0) {
            foreach ($proficiencies as $proficiency) {
                $this->profile->addProficiency($proficiency);
            }
        } else {
            $proficiency = new Proficiencies();
            $this->profile->addProficiency($proficiency);
        }
    }

    private function loadConfiguration() {
        $user = $this->getUser();
        $filesystem = new Filesystem();
        $configuration = $this->getEntityManager()->getRepository('App:Configuration')->findOneBy(['index' => $user->getId()]);
        if ($configuration) {
            if ($configuration->getBackgroundImage() && $filesystem->exists($configuration->getBackgroundImage())) {
                $configuration->setBackgroundImage(new File($configuration->getBackgroundImage()));
                $this->current_background = $configuration->getBackgroundImage();
            }
            $this->profile->setConfiguration($configuration);
        } else {
            $configuration = new Configuration();
            $configuration->setIndex($user->getId());
            $this->profile->setConfiguration($configuration);
        }
    }

}
