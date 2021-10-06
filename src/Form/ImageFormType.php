<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class ImageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('file', FileType::class, [
                'constraints' => [
                    new Image([
                        'maxSize' => '128M',
                        'mimeTypes' => ["image/png", "image/jpeg", "image/jpg"],
                        'mimeTypesMessage' => 'Not valid image. jpg and png are only allowed.',
                    ]),
                ],
                'attr' => [
                    'accept' => 'image/png, image/jpeg',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
