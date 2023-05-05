<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EditProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            /*  ->add('password') */
            ->add('prenom')
            ->add('nom')
            ->add('mail')
            ->add('genre', ChoiceType::class, [
                "choices" => [
                    'Homme' => '0',
                    'Femme' => '1'
                ]
            ])
            ->add('niveau', ChoiceType::class, [
                "choices" => [
                    'Débutant' => '0',
                    'Intermédiaire' => '1',
                    'Avancé' => '2'
                ]
            ])
            ->add('age');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
