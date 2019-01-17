<?php

namespace App\Controller;

use App\Entity\Profile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ProfileController extends AbstractController
{
    public function new(Request $request)
    {
        // creates a task and gives it some dummy data for this example
        $profile = new Profile();
        $profile->setTask('Write a blog post');
        $profile->setDueDate(new \DateTime('tomorrow'));

        $form = $this->createFormBuilder($profile)
            ->add('task', TextType::class)
            ->add('dueDate', DateType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Task'])
            ->getForm();

        return $this->render('default/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
