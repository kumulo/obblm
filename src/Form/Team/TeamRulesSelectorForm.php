<?php

namespace App\Form\Team;

use App\Entity\Championship;
use App\Entity\Rule;
use App\Entity\Team;
use App\Service\RuleService;
use App\Service\TeamService;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
        if($team = $builder->getData()) {
            if($rule = TeamService::getTeamRule($team)) {
                $rosters = RuleService::getAvailableRosters($rule);
                $choices = [];
                foreach($rosters as $roster) {
                    $translation_key = RuleService::composeTranslationRosterKey($rule->getRuleKey(), $roster);
                    $choices[$translation_key] = $roster;
                }

                $builder
                    ->add('name')
                    ->add('roster', ChoiceType::class, [
                    'choices' => $choices,
                    'translation_domain' => $rule->getRuleKey() ?? false
                ]);
            }
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Team::class,
        ));
    }
}