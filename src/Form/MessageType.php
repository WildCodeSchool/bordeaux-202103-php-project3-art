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
            ->add('mail', EmailType::class, [
                'label' => 'Votre adresse mail',
                'label_attr' => [
                    'class' => 'font-regular text-uppercase'
                ]
            ]);
        if ($options['is_buying']) {
            $builder
                ->add('object', TextType::class, [
                    'label' => 'Objet du message',
                    'attr' => [
                        'value' => $options['artwork_name']
                    ],
                    'label_attr' => [
                        'class' => 'font-regular text-uppercase'
                    ]
                ]);
        } else {
            $builder
                ->add('object', TextType::class, [
                    'label' => 'Objet du message',
                    'label_attr' => [
                        'class' => 'font-regular text-uppercase'
                    ]
                ]);
        }
        $builder
            ->add('content', TextareaType::class, [
                'label' => 'Votre message',
                'label_attr' => [
                    'class' => 'font-regular text-uppercase'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
            'is_buying' => false,
            'artwork_name' => null,
        ]);
    }
}
