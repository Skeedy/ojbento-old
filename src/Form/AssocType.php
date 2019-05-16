<?php

namespace App\Form;

use App\Entity\Allergen;
use App\Entity\Assoc;
use App\Form\DataTransformer\MenuToNumberTransformer;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AssocType extends AbstractType
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $tranformer = new MenuToNumberTransformer($this->em);
        $builder
            ->add('product', ProductType::class)
            ->add('quantity')
            ->add('image', ImageType::class)
            ->add('isDish')
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
            ->add('menu', HiddenType::class);
        $builder->get('menu')
            ->addModelTransformer($tranformer);
    }
}

class ApiProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('image', ImageType::class)
            ->add('allergen', EntityType::class, [
                'class' => Allergen::class,
                'multiple' => true,
                'expanded' => true,
                'choice_label' => function ($allergen) {
                    $test = $allergen->getImage();
                    return $test;
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Assoc::class,
        ]);
    }
}
