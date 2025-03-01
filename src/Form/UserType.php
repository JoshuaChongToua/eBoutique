<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
//            ->add('roles', ChoiceType::class, [
//                'choices'  => [
//                    'Utilisateur' => 'ROLE_USER',
//                    'Administrateur' => 'ROLE_ADMIN',
//                    'Super Admin' => 'ROLE_SUPER_ADMIN',
//                ],
//                'expanded' => true,  // Affiche en checkboxes
//                'multiple' => true,  // Permet de sélectionner plusieurs rôles
//                'label' => 'Rôles',
//                'mapped' => true,   // S'assure que le champ est bien lié à l'entité User
//            ])
            ->add('password', PasswordType::class)
            ->add('nom')
            ->add('prenom')
            ->add('adresse')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
