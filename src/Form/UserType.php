<?php

namespace App\Form;

use App\Entity\Band;
use App\Entity\Picture;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('name')
            ->add('lastname')
            ->add('roles')
            ->add('password')
            ->add('hall', EntityType::class, [
                'class'        => Picture::class,
                'choice_label' => 'name',
            ])
            ->add('bands', EntityType::class, [
                'class'        => Band::class,
                'choice_label' => 'name',
                'multiple'     => true,
                'expanded'     => true,
                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
