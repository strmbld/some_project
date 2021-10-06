<?php

namespace App\Form;

use App\Entity\Color;
use App\Entity\Figure;
use App\Entity\Shape;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FigureFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('color', EntityType::class, [
                'class' => Color::class,
                'required' => true,
                'placeholder' => 'Choose a color',
            ])
            ->add('shape', EntityType::class, [
                'class' => Shape::class,
                'required' => true,
                'placeholder' => 'Choose a shape',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Figure::class,
        ]);
    }
}
