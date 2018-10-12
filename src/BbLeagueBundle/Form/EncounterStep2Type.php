<?php

namespace BbLeagueBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EncounterStep2Type extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $baserule = $options['rule']->getRule();
        /** @var \BbLeagueBundle\Entity\Encounter $encounter */
        $encounter = $builder->getData();
        $builder
            ->add('home_actions', CollectionType::class, array(
                'entry_type' => ActionType::class,
                'allow_add'  => true,
                'delete_empty'  => true,
                'entry_options' => [
                    'team' => $encounter->getTeam(),
                ],
            ))
            ->add('home_injuries', CollectionType::class, array(
                'entry_type' => InjuryType::class,
                'allow_add'  => true,
                'delete_empty'  => true,
                'entry_options' => [
                    'team' => $encounter->getTeam(),
                ],
            ))
            ->add('visitor_actions', CollectionType::class, array(
                'entry_type' => ActionType::class,
                'allow_add'  => true,
                'delete_empty'  => true,
                'entry_options' => [
                    'team' => $encounter->getVisitor(),
                ],
            ))
            ->add('visitor_injuries', CollectionType::class, array(
                'entry_type' => InjuryType::class,
                'allow_add'  => true,
                'delete_empty'  => true,
                'entry_options' => [
                    'team' => $encounter->getVisitor(),
                ],
            ));

    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BbLeagueBundle\Entity\Encounter',
            'rule' => \BbLeagueBundle\Entity\Rule::class,
            'translation_domain' => 'form'
        ));

    }
    public function getName()
    {
        return 'obbml_encounter_step2';
    }
}