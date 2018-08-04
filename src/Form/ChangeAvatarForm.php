<?php
/**
 * Created by PhpStorm.
 * User: eugene
 * Date: 04.08.18
 * Time: 15:06
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class ChangeAvatarForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image',FileType::class,['label'=>'choose photo'])
            ->add('save',SubmitType::class,['label'=>'Save'])
            ->getForm();
    }
}