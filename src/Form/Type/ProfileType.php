<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use App\Form\Type\ProjectHistoryType;
use App\Form\Type\ProficienciesType;
use App\Form\Type\ProjectSamplesType;
use App\Form\Type\ConfigurationType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Profile;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class ProfileType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('title', TextType::class, [
                    'attr' => ['class' => 'form-control-sm', 'maxlength' => 255],
                    'label' => 'Personal Title',
                    'required' => true,
                ])
                ->add('first_name', TextType::class, [
                    'attr' => ['class' => 'form-control-sm', 'maxlength' => 255],
                    'label' => 'First Name',
                    'required' => true,
                ])
                ->add('last_name', TextType::class, [
                    'attr' => ['class' => 'form-control-sm', 'maxlength' => 255],
                    'label' => 'Last Name',
                    'required' => true,
                ])
                ->add('image', FileType::class, [
                    'data_class' => null,
                    'label' => 'An image representing you (gif,png,jpeg)',
                    'attr' => ['class' => 'form-control-sm'],
                    'required' => false,
                ])
                ->add('email', EmailType::class, [
                    'attr' => ['class' => 'form-control-sm', 'maxlength' => 255],
                    'label' => 'Email Address',
                    'required' => true,
                ])
                ->add('phone', TelType::class, [
                    'attr' => ['class' => 'form-control-sm', 'maxlength' => 255],
                    'label' => 'Phone Number',
                    'required' => false,
                ])
                ->add('location', TextType::class, [
                    'attr' => ['class' => 'form-control-sm', 'maxlength' => 255],
                    'label' => 'Location',
                    'required' => false,
                ])
                ->add('background', CKEditorType::class, [
                    'attr' => ['class' => 'form-control-sm ckeditor'],
                    'label' => 'Background Info',
                    'config' => [
                        'allowedContent' => 'p u em strong ol ul li;a[!href,target]'
                    ],
                    'required' => true,
                ])
                ->add('summary', CKEditorType::class, [
                    'attr' => ['class' => 'form-control-sm ckeditor', 'maxlength' => 1024],
                    'label' => 'Summary (this will only appear on the resume printout)',
                    'config' => [
                        'allowedContent' => 'p u em strong ol ul li;a[!href,target]'
                    ],
                    'required' => false,
                ])
                ->add('linkedin', TextType::class, [
                    'attr' => ['class' => 'form-control-sm', 'maxlength' => 255],
                    'label' => 'LinkedIn',
                    'required' => false,
                ])
                ->add('github', TextType::class, [
                    'attr' => ['class' => 'form-control-sm', 'maxlength' => 255],
                    'label' => 'GitHub',
                    'required' => false,
                ])
                ->add('gitlab', TextType::class, [
                    'attr' => ['class' => 'form-control-sm', 'maxlength' => 255],
                    'label' => 'GitLab',
                    'required' => false,
                ])
                ->add('stackoverflow', TextType::class, [
                    'attr' => ['class' => 'form-control-sm', 'maxlength' => 255],
                    'label' => 'StackOverflow (id number)',
                    'required' => false,
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
                ->add('project_samples', CollectionType::class,
                        [
                            'entry_type' => ProjectSamplesType::class,
                            'entry_options' => [
                                'label' => false
                            ],
                            'by_reference' => false,
                            'allow_add' => true,
                            'allow_delete' => true
                        ]
                )
                ->add('configuration', ConfigurationType::class
                )
                ->add('save', SubmitType::class, ['label' => 'Save Profile', 'attr' => ['class' => 'btn btn-primary my-2']]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Profile::class
        ]);
    }

}
