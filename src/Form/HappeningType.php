<?php

namespace App\Form;

use App\Entity\Happening;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HappeningType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de l\'évenement',
            ])
            ->add('content', CKEditorType::class, [
                'config' => [
                    'uiColor' => '#c1baba',
                ],
                'label' => 'Contenu',
            ])
            ->add('imageHappening', ImageHappeningType::class, [
                'label' => false,
            ])
            ->add('dateStart', DateType::class, [
                'label' => 'Date de commencement de l\'évenement',
            ])
            ->add('dateEnd', DateType::class, [
                'label' => 'Date de fin de l\'évenement',

            ])
            ->add('timeStart', TimeType::class, [
                'label' => 'Heure de début  de l\'évenement',
            ])
            ->add('timeEnd', TimeType::class, [
                'label' => 'Heure de fin  de l\'évenement',
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Happening::class,
        ]);
    }
}
