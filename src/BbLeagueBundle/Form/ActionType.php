<?php

namespace BbLeagueBundle\Form;

use BbLeagueBundle\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Team $team */
        $team = $options['team'];
        $builder
            ->add(
                'player',
                EntityType::class,
                array(
                    'class' => 'BbLeagueBundle:Player',
                    'choice_label' => 'name',
                    'required' => true,
                    'choices' => $team->getPlayers(),
                ))
            ->add('pass', null)
            ->add('td', null)
            ->add('int', null)
            ->add('injury', null)
            ->add('jpv', null)
            ->add('agr', null)
            ->add('car', null);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain' => 'form',
            'team' => Team::class,
        ));

    }

    public function getName()
    {
        return 'obbml_forms_user_encounter_action';
    }
}
