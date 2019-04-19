<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Form\Type\ProfileType;
use App\Entity\ProjectHistory;
use App\Entity\Proficiencies;
use App\Entity\ProjectSamples;
use App\Entity\Configuration;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;
use App\Service\FileUploader;
use Symfony\Component\Filesystem\Filesystem;
use App\Controller\BrandIconsApiController;

class ProfileController extends AbstractController {

    protected $entity_manager;
    protected $profile;
    protected $user;
    protected $current_avatar;
    protected $current_background;
    protected $project_images;

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
            if ($this->profile && $this->profile->getImage() && $filesystem->exists($this->profile->getImage())) {
                $this->profile->setImage(new File($this->profile->getImage()));
                $this->current_avatar = $this->profile->getImage();
            }else{
                $this->profile=new Profile();
                $this->profile->setUserId($user);
            }
        }
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
        $sample_exists = [];
        $filesystem = new Filesystem();
        $user = $this->getUser();

        if ($user->getId()) {
            $profile = $this->getProfile();
            $this->loadHistories();
            $this->loadProficiencies();
            $this->loadConfiguration();
            $this->loadProjectSamples();
            $backgroud_exists = $this->current_background && $filesystem->exists($this->getParameter('images_directory') . '/' . $this->current_background->getBasename()) ? $this->current_background->getBasename() : null;
            $avatar_exists = $this->current_avatar && $filesystem->exists($this->getParameter('images_directory') . '/' . $this->current_avatar->getBasename()) ? $this->current_avatar->getBasename() : null;
            foreach ($this->project_images as $key => $project_image) {
                $sample_exists[$key] = $project_image->getBasename();
            }
        } else {
            $profile = new Profile();
            $profile->setUserId($user);
            $project_history = new ProjectHistory();
            $proficiency = new Proficiencies();
            $project_sample = new ProjectSamples();
            $profile->addProjectHistory($project_history);
            $profile->addProficiency($proficiency);
            $profile->addProjectSample($project_sample);
        }

        $form = $this->createForm(ProfileType::class, $profile);

        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {
            $avatar = $form->get('image')->getData();

            if ($avatar) {
                $current_avatar = $this->current_avatar && is_object($this->current_avatar) ? $this->current_avatar->getBasename() : null;

                $avatar_uploader = new FileUploader('images_directory', $current_avatar);
                $avatar_filename = $avatar_uploader->upload($avatar,'avatar');
                $avatar_exists = $avatar_filename;
                $profile->setImage(new File($this->getParameter('images_directory') . '/' . $avatar_filename));
            }

            $background = $form->get('configuration')->get('background_image')->getData();
            if ($background) {
                $current_background = $this->current_background && is_object($this->current_background) ? $this->current_background->getBasename() : null;
                $background_uploader = new FileUploader('images_directory', $current_background);
                $background_filename = $background_uploader->upload($background,'background');
                $backgroud_exists = $background_filename;
                $profile->getConfiguration()->setBackgroundImage(new File($this->getParameter('images_directory') . '/' . $background_filename));
            }

            $project_samples = $form->get('project_samples');
            foreach ($project_samples as $project_sample) {
                $project_image = $project_sample->get('project_image')->getData();
                $sample_entity = $project_sample->getViewData();
                $sample_index = $sample_entity->getSampleIndex();
               

                if ($project_image && $sample_index) {
                    $current_project_image = array_key_exists($sample_index, $this->project_images) && is_object($this->project_images[$sample_index]) ? $this->project_images[$sample_index]->getBasename() : null;
                    $sample_uploader = new FileUploader('images_directory/project_samples', $current_project_image);
                    $sample_filename = $sample_uploader->upload($project_image);
                    $sample_exists[$sample_index] = $sample_filename;
                    $sample_entity->setProjectImage(new File($this->getParameter('images_directory') . '/project_samples/' . $sample_filename));
                }
            }
            $this->getEntityManager()->persist($profile);
            $this->getEntityManager()->flush();
        }


        return $this->render('profile/profile.html.twig', [
                    'form' => $form->createView(),
                    'avatar_exists' => $avatar_exists,
                    'background_exists' => $backgroud_exists,
                    'sample_exists' => $sample_exists
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

    private function loadProjectSamples() {
        $this->project_images = [];
        $filesystem = new Filesystem();
        $project_samples = $this->getEntityManager()->getRepository('App:ProjectSamples')->findAll();
        if (count($project_samples) > 0) {
            foreach ($project_samples as $project_sample) {
                if ($project_sample->getTitle()) {
                    $project_sample->setSampleIndex($project_sample->getIndex());
                    if ($project_sample->getSampleIndex() && $project_sample->getProjectImage() && $filesystem->exists($project_sample->getProjectImage())) {
                        $this->project_images[$project_sample->getIndex()] = new File($project_sample->getProjectImage());
                    }
                    $this->profile->addProjectSample($project_sample);
                } else {
                    $this->profile->removeProjectSample($project_sample);
                }
            }
        } else {
            $project_sample = new ProjectSamples();
            $project_sample->setSampleIndex(md5(uniqid()));
            $this->profile->addProjectSample($project_sample);
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
