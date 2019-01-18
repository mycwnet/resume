<?php

namespace App\Controller;

use App\Entity\Profile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProfileController extends AbstractController {

    /**
     * Matches /profile exactly
     *
     * @Route("/profile", name="resume_profile")
     */
    public function new(Request $request) {
        $profile = new Profile();

        $form = $this->createFormBuilder($profile)
                ->add('title', TextType::class)
                ->add('firstName', TextType::class)
                ->add('lastName', TextType::class)
                ->add('email', EmailType::class)
                ->add('phone', TelType::class)
                ->add('background', TextareaType::class)
                ->add('save', SubmitType::class, ['label' => 'Save Profile'])
                ->getForm();

        return $this->render('profile/profile.html.twig', [
                    'form' => $form->createView(),
        ]);
    }

}
