<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use App\Entity\ProjectSamples;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectSamplesType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('title', TextType::class, [
                    'attr' => ['class' => 'form-control-sm'],
                    'label' => 'Project Sample Title',
                    'required' => false
                ])
                ->add('project_image', FileType::class, [
                    'attr' => ['class' => 'form-control-sm'],
                    'data_class' => null,
                    'label' => 'Project Sample Image',
                    'required' => false
                ])
                ->add('blurb', TextareaType::class, [
                    'attr' => ['class' => 'form-control-sm'],
                    'label' => 'Project Sample Blurb',
                    'required' => false,
                ])
                ->add('link', TextType::class, [
                    'attr' => ['class' => 'form-control-sm'],
                    'label' => 'Project Sample Link',
                    'required' => false
                ]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => ProjectSamples::class
        ]);
    }

}
