<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;


class SearchForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('question',TextType::class)
            ->add('filter',ChoiceType::class,[
                'choices' =>[
                    'Only Messages' => 1,
                    'Only Topics' => 2,
                    'Messages and Topics' => 3
                ]
            ])
            ->add('save',SubmitType::class,['label'=>'Search'])
            ->getForm();
    }


}