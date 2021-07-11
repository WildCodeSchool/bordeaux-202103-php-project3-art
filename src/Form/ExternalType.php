<?php

namespace App\Form;

use App\Entity\ExternalArticle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class ExternalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de l\'évenement',
            ])
            ->add('link', TextType::class, [
                'label' => 'URL de l\'article',
            ])

            ->add('imageExternalArticle', ImageExternalType::class, [
                'label' => false,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ExternalArticle::class,
        ]);
    }
}
