<?php

namespace App\Form;

use App\Entity\Assoc;
use App\Entity\Product;
use App\Entity\Type;
use App\Form\DataTransformer\MenuToNumberTransformer;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormEvent;

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
            ->add ('type', EntityType::class,[
                'class' => Type::class,
                'multiple'=> false,
                'expanded'=> true,
                'mapped'=>false

            ]);

        $formModifier = function (FormInterface $form, Type $type = null) {
            $product = null === $type ? [] : $type->getProducts();

            $form ->add('product', EntityType::class, [
            'class' => Product::class,
            'choices' => $product,

            ]);

        };
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                $data = $event->getData();
                $formModifier($event->getForm(), $data->getProduct());
            }
        );
        $builder->get('type')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier){
                $type = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(),$type);
            }
        );
        $builder
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
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Assoc::class,
        ]);
    }
}
