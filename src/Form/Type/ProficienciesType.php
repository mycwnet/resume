<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use App\Entity\Proficiencies;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProficienciesType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('title', TextType::class, [
                    'attr' => ['class' => 'form-control-sm'],
                    'label' => 'Proficiency Title',
                    'required' => true,
                ])
                ->add('years', IntegerType::class, [
                    'label' => 'Years of Practice',
                    'required' => true,
                    'attr' => [
                        'min' => 0, 'max' => 75,
                        'class' => 'form-control-sm'
                    ]
                ])
                ->add('percent', IntegerType::class, [
                    'label' => 'Percent of Mastery',
                    'required' => true,
                    'attr' => [
                        'min' => 0, 'max' => 100,
                        'class' => 'form-control-sm'
                    ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Proficiencies::class
        ]);
    }

}
