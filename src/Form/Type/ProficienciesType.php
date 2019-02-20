<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use App\Entity\Proficiencies;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProficienciesType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('Title', TextType::class)
                ->add('Years', IntegerType::class, ['attr' => ['min' => 0, 'max' => 75]])
                ->add('Percent', NumberType::class, ['attr' => ['min' => 0, 'max' => 75]]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Proficiencies::class
        ]);
    }

}
