<?php

namespace App\Form;

use App\Entity\InscriFormation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriFormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('etat', ChoiceType::class, array(
                'choices' =>array(
                    'Pending'=> 'pending',
                    'Valide'=> 'valide') ,
                'label' => 'Etat :'));

           /* ->add('NomFormation');
            ->add('session',EntityType::class,
                ['class'=>'App\Entity\Session',
                    'choice_label'=>'nomf',
                    'expanded'=>false,
                    'multiple'=>false])
            ->add('candidate',EntityType::class,
                ['class'=>'App\Entity\User2',
                    'choice_label'=>'email',
                    'expanded'=>false,
                    'multiple'=>false])
        ;*/
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InscriFormation::class,
        ]);
    }
}
