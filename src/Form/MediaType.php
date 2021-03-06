<?php

namespace App\Form;

use App\Entity\Media;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('support', ChoiceType::class, [
                'choices' => [
                    'photo' => 'photo',
                    'video' => 'video',
                ],
            ])
            ->add('url', TextType::class,[
                'required'=>false,
            ])
            ->add('imageArtwork',ImageArtworkType::class,[
                'label'=>false,
            ]);
   }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Media::class,
        ]);
    }
}
