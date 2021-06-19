<?php

namespace App\Form;

use App\Entity\Avatar;
use App\Entity\Discipline;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('pseudo', TextType::class, [
                'label' => 'Nom d\'artiste',
                'required' => false,
            ])
            ->add('avatar', AvatarType::class,[
                'label'=>false,
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'required' => false,
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'required' => false,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
            ])

            ->add('expertise', TextType::class, [
                'label' => 'Compétence',
                'required' => false,
            ])
            ->add('facebookUrl', TextType::class, [
                'label' => 'URL Facebook',
                'required' => false,
            ])
            ->add('instagramUrl', TextType::class, [
                'label' => 'URL Instagram',
                'required' => false,
            ])
            ->add('disciplines', EntityType::class, [
                'class' => Discipline::class,
                'choice_label' => 'name',
                'expanded' => true,
                'multiple' => true,
                'required' => false,
                'by_reference' => false,
            ])
            ->add('city', CityType::class, [
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
