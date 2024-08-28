<?php

namespace App\Form;

use App\Entity\Filament;
use App\Entity\FilamentBasecolor;
use App\Entity\FilamentMaterial;
use App\Entity\FilamentVendor;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilamentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('qrcode')
            ->add('color')
            ->add('colorhex')
            ->add('specs')
            ->add('image')
            ->add('link')
            ->add('vendor', EntityType::class, [
                'class' => FilamentVendor::class,
                'choice_label' => 'id',
            ])
            ->add('material', EntityType::class, [
                'class' => FilamentMaterial::class,
                'choice_label' => 'id',
            ])
            ->add('basecolor', EntityType::class, [
                'class' => FilamentBasecolor::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Filament::class,
        ]);
    }
}
