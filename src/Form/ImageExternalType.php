<?php

namespace App\Form;

use App\Entity\ImageExternalArticle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ImageExternalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile', VichFileType::class, [
                'required' => false,
                'allow_delete' => false,
                'download_uri' => false,
                'label' => false,
                'attr' => ['lang' => 'fr'],
                'constraints' => [new File([
                    'maxSize' => '4M',
                    'maxSizeMessage' => 'Taille max de fichier 4M',
                    'mimeTypes' => [
                        'image/jpg',
                        'image/png',
                        'image/jpeg'
                    ],
                    'mimeTypesMessage' => 'Format valide: png, jpeg, jpg'
                ])]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ImageExternalArticle::class,
        ]);
    }
}
