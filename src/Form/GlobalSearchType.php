<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GlobalSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Catégories' => 'category',
                    'Artistes' => 'artist',
                    'Evénements' => 'event',
                    'Lieux' => 'location'
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => false,
                'label_attr' => [
                    'class' => 'radio-inline d-flex justify-content-center font-medium p-2'
                ],
                'attr' => [
                    'class' => ''
                ],
            ])
            ->add('textTyped', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Rechercher',
                    'class' => 'font-medium',
                    ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
