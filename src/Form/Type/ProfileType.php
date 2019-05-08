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
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class ProfileType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('title', TextType::class, [
                    'attr' => ['class' => 'form-control-sm'],
                    'label' => 'Personal Title',
                    'required' => true,
                ])
                ->add('first_name', TextType::class, [
                    'attr' => ['class' => 'form-control-sm'],
                    'label' => 'First Name',
                    'required' => true,
                ])
                ->add('last_name', TextType::class, [
                    'attr' => ['class' => 'form-control-sm'],
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
                    'attr' => ['class' => 'form-control-sm'],
                    'label' => 'Email Address',
                    'required' => true,
                ])
                ->add('phone', TelType::class, [
                    'attr' => ['class' => 'form-control-sm'],
                    'label' => 'Phone Number',
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
