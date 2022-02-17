<?php

namespace App\Form;

use App\Entity\Avatar;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Vich\UploaderBundle\Form\Type\VichFileType;

class AvatarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile', VichFileType::class, [
                'required' => true,
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Avatar::class,
        ]);
    }
}
