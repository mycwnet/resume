<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use App\Entity\Proficiencies;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Controller\BrandIconsApiController;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class ProficienciesType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('title', TextType::class, [
                    'attr' => ['class' => 'form-control-sm proficiency-title'],
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
                ])
                ->add('icon', ChoiceType::class, [
                    'label' => 'Suggested Icons',
                    'required' => false,
                    'choices' => [],
                    'allow_extra_fields' => true,
                ])->add('icon_value', HiddenType::class, [
            'attr' => ['class' => 'hidden-icon-value']
        ]);

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $this->loadIconList($event);
        });

        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
            $this->loadIconList($event, $submit = true);
        });
    }

    private function loadIconList($event, $submitted = false) {
        $proficiency = $event->getData();
        $form = $event->getForm();
        $view = $submitted ? $form->getViewData() : [];
        $choice = null;

        if (!empty($view) && $view->getIconValue()) {
            $choice = $view->getIconValue();
            $view->setIcon($choice);
        }

        if ($proficiency && null != $proficiency->getTitle()) {
            $title = $proficiency->getTitle();
            $brand_icons = new BrandIconsApiController();
            $suggested_icons = $brand_icons->getBestMatches($title);
            $form->add('icon', ChoiceType::class, [
                'label' => 'Suggested Icons',
                'required' => false,
                'choices' => $suggested_icons,
                'expanded' => true,
                'multiple' => false,
                'allow_extra_fields' => true,
                'choice_label' => function ($choice, $key, $value) {
                    return '<i class="fab fa-' . $choice . ' fa-3x"></i>';
                }
            ]);
        }
    }



    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Proficiencies::class
        ]);
    }

}
