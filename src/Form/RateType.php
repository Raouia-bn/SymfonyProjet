<?php

namespace App\Form;

use App\Entity\Rate;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('rating', ChoiceType::class,
                ['choices' => [
                    '1'=> '1' ,
                    '2'=> '2' ,
                    '3'=> '3' ,
                ]])
            ->add('comment')
            ->add('candidate', EntityType::class,
            ['class'=>'App\Entity\User2',
                'choice_label'=>'email',
                'expanded'=>false,
                'multiple'=>false])

            ->add('formation',EntityType::class,
                ['class'=>'App\Entity\Formation',
                    'choice_label'=>'nomf',
                    'expanded'=>false,
                    'multiple'=>false])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rate::class,
        ]);
    }
}
