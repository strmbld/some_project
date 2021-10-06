<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AttachmentsImagesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(0, ImageFormType::class, [
                'mapped' => false,
                'required' => true,
                'label' => 'required_image',
            ])
            ->add(1, ImageFormType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'optional_image1',
            ])
            ->add(2, ImageFormType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'optional_image2',
            ])
            ->add(3, ImageFormType::class, [
                'mapped' => false,
                'required' => false,
                'label' => 'optional_image3',
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
