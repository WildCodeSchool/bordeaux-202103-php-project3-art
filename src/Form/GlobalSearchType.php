<?php

namespace App\Form;

use App\Entity\GlobalSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
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
                    'catégories' => 'category',
                    'artistes' => 'artist',
                    'événements' => 'event',
                    'lieux' => 'location',
                    'annonces' => 'announcement'
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => false,
                'label_attr' => [
                    'class' => 'navbar-label d-flex justify-content-center font-medium 
                    text-uppercase p-2 mt-1'
                ],
                'attr' => [
                    'class' => 'navbar-radio'
                ],
            ])
            ->add('textTyped', SearchType::class, [
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
            'data_class' => GlobalSearch::class,
        ]);
    }
}
