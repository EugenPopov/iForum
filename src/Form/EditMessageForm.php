<?php
/**
 * Created by PhpStorm.
 * User: eugene
 * Date: 02.08.18
 * Time: 14:33
 */

namespace App\Form;



use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormTypeInterface;

class EditMessageForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text',TextType::class)
            ->add('save',SubmitType::class,['label'=>'Search'])
            ->getForm();
    }
}