<?php

namespace App\Form;

use App\Entity\Presentation;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PresentationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description',CKEditorType::class,[
                    'config' => [
                        'uiColor' => '#c1baba',
                    ],
                    'label' => false
                ]

            )
            ->add('imageFile', VichFileType::class,[
                'allow_delete' => false,
                'download_uri' => false,
                'label' => false,
                'attr' => ['lang' => 'fr'],
                'constraints' => [new File([
                    'maxSize' => '2M',
                    'maxSizeMessage' => 'Taille max de fichier 2M',
                    'mimeTypes' => [
                        'image/jpg',
                        'image/png',
                        'image/jpeg'
                    ],
                    'mimeTypesMessage' => 'Format valide: png, jpeg, jpg'
                ])]
            ])
            ->add('copyright', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Presentation::class,
        ]);
    }
}
