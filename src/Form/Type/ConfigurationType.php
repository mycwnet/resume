<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use App\Entity\Configuration;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfigurationType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('dateformat', ChoiceType::class, [
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
                ->add('background_image', FileType::class,[
                    'attr' => ['class' => 'form-control-sm'],
                    'data_class' => null,
                    'label' => 'Background theme image',
                    'required' => false
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
