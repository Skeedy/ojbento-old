<?php

namespace App\Form;

use App\Entity\Menu;
use App\Entity\Assoc;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('assoc', EntityType::class, [
                'class' => Assoc::class,
                'multiple' => true,
                'expanded' => true
            ])
            ->add('quantity', ChoiceType::class, array(
                'choices' => range(1,10,0.5
                )
            ))
            ->add('midi')

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Menu::class,
        ]);
    }
}
