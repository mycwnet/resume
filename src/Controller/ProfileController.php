<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Form\Type\ProfileType;
use App\Entity\ProjectHistory;
use App\Entity\Proficiencies;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController {

    protected $entity_manager;
    protected $profile;
    protected $user;

    private function getEntityManager() {
        if (null === $this->entity_manager) {
            $this->entity_manager = $this->getDoctrine()->getManager();
        }

        return $this->entity_manager;
    }

    private function getProfile() {
        $user = $this->getUser();
        if (null === $this->profile) {
            $this->profile = $this->getEntityManager()
                    ->getRepository('App:Profile')
                    ->findOneBy(['user_id' => $user->getId()]);
        }

        return $this->profile;
    }

    /**
     * Matches /profile exactly
     *
     * @Route("/profile", name="resume_profile")
     */
    public function new(Request $request) {

        $user = $this->getUser();
        if ($user->getId()) {
            $profile = $this->getProfile();
            $this->loadHistories();
            $this->loadProficiencies();
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

        if ($form->isSubmitted()) {
            $this->getEntityManager()->persist($profile);
            $this->getEntityManager()->flush();
        }


        return $this->render('profile/profile.html.twig', [
                    'form' => $form->createView(),
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

}
