<?php

namespace App\Form;

use App\Entity\ReclamationCandFormat;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReclamationCandFormatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description')
            ->add('motifReclamation',EntityType::class,
                ['class'=>'App\Entity\MotifReclamation',
                    'choice_label'=>'designation',
                    'multiple'=>false,
                    'expanded'=>false])

            ->add('candidat',EntityType::class,
        ['class'=>'App\Entity\User2',
            'choice_label'=>'email',
            'multiple'=>false,
            'expanded'=>false])
            ->add('formateur', EntityType::class,
        ['class'=>'App\Entity\User2',
            'choice_label'=>'email',
            'multiple'=>false,
            'expanded'=>false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ReclamationCandFormat::class,
        ]);
    }
}
