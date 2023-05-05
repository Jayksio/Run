<?php

namespace App\Form;

use App\Entity\Chaussures;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ChaussuresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('couleur')
            ->add('niveau', ChoiceType::class, [
                'choices' => [
                    'Débutant' => '0',
                    'Intermédiaire' => '1',
                    'Avancé' => '2'
                ]
            ])
            ->add('description')
            ->add('prix')
            ->add('image');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chaussures::class,
        ]);
    }
}
