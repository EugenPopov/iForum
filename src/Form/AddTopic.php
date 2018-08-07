<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Sections;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AddTopic extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label'=>'popov', 'data'=>'default'])
            ->add('section', EntityType::class, [
                'class' => Sections::class,
                'choice_label' => 'name',
                'data'=>'abcdef', ])
            ->add('save', SubmitType::class, ['label'=>'Create Topic'])
            ->getForm();
    }
}
