<?php
namespace App\Form;
use App\Entity\Product;
use App\Entity\Allergen;
use App\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', EntityType::class,[
                'class' => Type::class,
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('name')
            ->add('description')
            ->add('composition')
            ->add('allergen', EntityType::class,[
                'class'=> Allergen::class,
                'expanded'=> true,
                'multiple'=> true
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
