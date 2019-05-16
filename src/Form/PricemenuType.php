<?php

namespace App\Form;

use App\Entity\Pricemenu;
use App\Form\DataTransformer\AssocToNumberTransformer;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PricemenuType extends AbstractType
{
    protected $em;

    public function __construct(EntityManager $em){
        $this->em = $em;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $tranformer = new AssocToNumberTransformer($this->em);
        $builder
            ->add('value')
            ->add('type')
            ->add('menu', HiddenType::class)
        ;
        $builder->get('menu')
            ->addModelTransformer($tranformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pricemenu::class,
        ]);
    }
}
