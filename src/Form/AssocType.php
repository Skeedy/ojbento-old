<?php

namespace App\Form;

use App\Entity\Assoc;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AssocType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('product', ProductType::class)
            ->add('quantity')
            ->add('isDish')
            ->add('prices' , CollectionType::class, [
                'entry_type' => PriceassocType::class,
                'entry_options' => [
                    'label' => false,
                    'attr' => array('class'=> 'prices')
                ],
                'prototype'=> true,
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
