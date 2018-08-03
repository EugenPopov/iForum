<?php
/**
 * Created by PhpStorm.
 * User: eugene
 * Date: 03.08.18
 * Time: 22:33
 */

namespace App\Form;

use App\Entity\Sections;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class EditUserForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,['label'=>'popov', 'data'=>'default'])
            ->add
            ->add('save',SubmitType::class,['label'=>'Create Topic'])
            ->getForm();

    }
}
