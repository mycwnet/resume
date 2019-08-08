<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\CoverLetter;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class CoverLetterType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('addressee', TextType::class, [
                    'attr' => ['class' => 'form-control-sm', 'maxlength' => 255],
                    'label' => 'To',
                    'data' => 'Dear hiring manager,',
                    'required' => true,
                ])
                ->add('letter', CKEditorType::class, [
                    'attr' => ['class' => 'form-control-sm ckeditor'],
                    'label' => 'Letter Content',
                    'config' => [
                        'allowedContent' => 'p u em strong ol ul li;a[!href,target]'
                    ],
                    'required' => true,
                ])
                ->add('submit', SubmitType::class, ['label' => 'Submit And View', 'attr' => ['class' => 'btn btn-primary my-2']]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => CoverLetter::class
        ]);
    }

}
