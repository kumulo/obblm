<?php

namespace App\Form;

use App\Entity\Coach;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminUserForm extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', EmailType::class)
            ->add('plainPassword', PasswordType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Coach::class,
        ));
    }
}
