<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use App\Entity\ProjectHistory;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectHistoryType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('title', TextType::class, [
                    'attr' => ['class' => 'form-control-sm'],
                    'label' => 'Project Title',
                    'required' => true,
                ])
                ->add('description', TextareaType::class, [
                    'attr' => ['class' => 'form-control-sm'],
                    'label' => 'Project Description',
                    'required' => true,
                ])
                ->add('start', DateType::class, [
                    'years' => range(date('Y') - 20, date('Y')),
                    'attr' => ['class' => 'form-control-sm'],
                    'widget' => 'single_text',
                    'label' => 'Project Start Date',
                    'required' => true,
                ])
                ->add('end', DateType::class, [
                    'attr' => ['class' => 'form-control-sm'],
                    'widget' => 'single_text',
                    'label' => 'Project End Date',
                    'required' => false,
                    'years' => range(date('Y') - 20, date('Y'))
        ]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => ProjectHistory::class
        ]);
    }

}
