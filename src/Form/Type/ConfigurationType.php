<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use App\Entity\Configuration;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfigurationType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('site_title', TextType::class, [
                    'attr' => ['class' => 'form-control-sm'],
                    'label' => 'Site Title',
                    'required' => true,
                ])
                ->add('dateformat', ChoiceType::class, [
                    'choices' => [
                        'MDY (January 1st, 2000)' => 1,
                        'mmddyy (01/01/00)' => 2,
                        'mmddyyyy (01/01/2000)' => 3,
                        'YMD (2000 January 1st)' => 4,
                        'yymmdd (00/01/01)' => 5,
                        'yyyymmdd (2000/01/01)' => 6,
                        'DMY (1st January 2000)' => 7,
                        'ddmmyy (01/01/00)' => 8,
                        'ddmmyyyy (01/01/2000)' => 9,
                    ],
                    'attr' => [
                        'class' => 'form-control-sm'
                    ],
                    'label' => 'Date Format'
                ])
                ->add('background_image', FileType::class, [
                    'attr' => ['class' => 'form-control-sm'],
                    'data_class' => null,
                    'label' => 'Background theme image',
                    'required' => false
                ])
                ->add('site_logo', FileType::class, [
                    'data_class' => null,
                    'label' => 'Site logo (gif,png,jpeg)',
                    'attr' => ['class' => 'form-control-sm'],
                    'required' => false,
                ])
                ->add('favicon_image', FileType::class, [
                    'data_class' => null,
                    'label' => 'favicon image (16x16 or 32x32)',
                    'attr' => ['class' => 'form-control-sm'],
                    'required' => false,
                ])
                ->add('color', ColorType::class, [
                    'attr' => ['class' => 'form-control-sm'],
                    'label' => 'Base Theme Color'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Configuration::class
        ]);
    }

}
