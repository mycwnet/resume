<?php
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use App\Entity\ProjectHistory;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ProjectHistoryType extends AbstractType{
    
   public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Title', TextType::class)
                ->add('Description', TextareaType::class)
                ->add('Start', DateType::class, ['years' => range(date('Y')-20, date('Y'))])
                ->add('End', DateType::class, ['years' => range(date('Y')-20, date('Y'))]);
    }
        public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProjectHistory::class
        ]);
    }

}
