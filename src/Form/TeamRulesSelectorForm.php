<?php

namespace App\Form;

use App\Entity\Championship;
use App\Entity\Rule;
use App\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamRulesSelectorForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('rule', EntityType::class, [
                'required' => false,
                'class' => Rule::class,
                'choice_label' => 'rule_key',
                'placeholder' => 'Choose an option',
                'expanded' => true
            ])
            ->add('championship', EntityType::class, [
                'required' => false,
                'class' => Championship::class,
                'choice_label' => 'name',
                'placeholder' => 'Choose an option',
                'expanded' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Team::class,
        ));
    }
}