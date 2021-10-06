<?php

namespace App\Form;

use App\Entity\Record;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('text', TextareaType::class, [
                'required' => true,
            ])
            ->add('email', EmailType::class, [
                'required' => true,
            ])
            ->add('figure', FigureFormType::class, [
                'required' => true,
            ])
            ->add('attachments', AttachmentsImagesFormType::class, [
                'mapped' => false,
                'allow_file_upload' => true,
                'allow_extra_fields' => true,
                'attr' => [
                    'enctype' => 'multipart/form-data',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Record::class,
        ]);
    }
}
