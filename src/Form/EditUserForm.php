<?php
/**
 * Created by PhpStorm.
 * User: eugene
 * Date: 03.08.18
 * Time: 22:33
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class EditUserForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',TextType::class,['label'=>'popov'])
            ->add('email',TextType::class)
            ->add('oldPassword',PasswordType::class)
            ->add('plainPassword',RepeatedType::class,[
                'type'=>PasswordType::class,
                'first_options' => ['label'=>'Password'],
                'second_options' => ['label' => 'Repeat Password'],

            ])
//            ->add('image',FileType::class)

            ->add('save',SubmitType::class,['label'=>'Save'])
            ->getForm();
    }
}
