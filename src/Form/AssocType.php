<?php

namespace App\Form;

use App\Entity\Allergen;
use App\Entity\Assoc;
use App\Entity\Image;
use App\Form\PriceassocType;
use App\Entity\Product;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Type;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AssocType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product', EntityType::class, [
                "class" => Product::class
                    ])
            ->add('type', EntityType::class,[
                "class" => Type::class
            ])
            ->add('quantity')
            ->add('allergen', EntityType::class, array(
                "class" => Allergen::class,
                "multiple" => true,
                "expanded" => true
            ))
            ->add('image', ImageType::class)
            ->add('isDish')
            ->add('description')
            ->add('composition')
            ->add('prices', CollectionType::class, [
                'entry_type' => PriceassocType::class,
                'entry_options' => [
                    'label' => false,
                    'attr' => array('class' => 'prices')
                ],
                'prototype' => true,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Assoc::class,
        ]);
    }
}
