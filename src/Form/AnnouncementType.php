<?php

namespace App\Form;

use App\Entity\Announcement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnouncementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de l\'annonce'
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Description de l\'annonce'
            ])
            ->add('date', DateType::class, [
                'label' => 'Annonce disponible jusqu\'au',
                'widget'=>'single_text',

            ])
            ->add('time', TimeType::class, [
                'label' => 'Heure de l\'évenement'
            ])
            ->add('discipline', null, [
                'choice_label' => 'name'

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Announcement::class,
        ]);
    }
}
