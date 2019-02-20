<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use App\Form\Type\ProjectHistoryType;
use App\Form\Type\ProficienciesType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Profile;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('title', TextType::class, [
                    'attr' => ['class' => 'form-control-sm'],
                    'required' => true,
                ])
                ->add('firstName', TextType::class, [
                    'attr' => ['class' => 'form-control-sm'],
                    'required' => true,
                ])
                ->add('lastName', TextType::class, [
                    'attr' => ['class' => 'form-control-sm'],
                    'required' => true,
                ])
                ->add('email', EmailType::class, [
                    'attr' => ['class' => 'form-control-sm'],
                    'required' => true,
                ])
                ->add('phone', TelType::class, [
                    'attr' => ['class' => 'form-control-sm'],
                    'required' => false,
                ])
                ->add('background', TextareaType::class, [
                    'required'   => true,
                ])
                ->add('project_history', CollectionType::class,
                        [
                            'entry_type' => ProjectHistoryType::class,
                            'entry_options' => [
                                'label' => false
                            ],
                            'by_reference' => false,
                            'allow_add' => true,
                            'allow_delete' => true
                        ]
                )
                ->add('proficiencies', CollectionType::class,
                        [
                            'entry_type' => ProficienciesType::class,
                            'entry_options' => [
                                'label' => false
                            ],
                            'by_reference' => false,
                            'allow_add' => true,
                            'allow_delete' => true
                        ]
                )
                ->add('save', SubmitType::class, ['label' => 'Save Profile', 'attr' => ['class' => 'btn btn-primary my-2']]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Profile::class
        ]);
    }

}
