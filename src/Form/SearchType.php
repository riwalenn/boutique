<?php

namespace App\Form;

use App\Classe\Search;
use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('string', TextType::class, [
            'label' => false,
            'required' => false,
            'attr' => [
                'placeholder' => 'Rechercher...',
                'class' => 'form-control-sm'
            ]
        ])
        ->add('categories', EntityType::class, [
            'label' => 'Catégories',
            'required' => false,
            'class' => Category::class,
            'multiple' => true,
            'expanded' => true
        ])
        ->add('shape', ChoiceType::class, [
            'label' => 'Condition',
            'choices' => [
                'Neuf' => 'neuf',
                'D\'occasion' => 'occasion'
            ],
            'required' => false,
            'expanded' => true
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Valider',
            'attr' => [
                'class' => 'btn btn-block btn-primary'
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}