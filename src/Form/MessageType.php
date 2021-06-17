<?php

namespace App\Form;

use App\Entity\Message;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          /*  ->add('user', EntityType::class, [
                'class' => User::class,
                'label' => 'ECRIRE A UN ARTISTE',
                'choice_label' => 'pseudo',
                'multiple' => false,
                'expanded' => false,
                'by_reference' => false
            ]) */
            ->add('mail', EmailType::class, [
                'label' => 'VOTRE ADRESSE MAIL'
            ])
            ->add('object', TextType::class, [
                'label' => 'OBJET DU MESSAGE'
            ])
            ->add('content', TextareaType::class, [
                'label' => 'VOTRE MESSAGE'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
