<?php

namespace BbLeagueBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EncounterStep1Type extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $baserule = $options['rule']->getRule();
        $weather = [];
        foreach ($baserule['fields']['default']['weather'] as $key => $value) {
            $weather[$value] = $key;
        }
        $fields = [];
        foreach ($baserule['fields'] as $key => $value) {
            $fields[$key] = $key;
        }
        $builder
            ->add(
                'weather',
                ChoiceType::class,
                array(
                    'required' => true,
                    'choices' => $weather,
                )
            )
            ->add(
                'field',
                ChoiceType::class,
                array(
                    'required' => true,
                    'choices' => $fields,
                )
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'BbLeagueBundle\Entity\Encounter',
                'rule' => \BbLeagueBundle\Entity\Rule::class,
                'translation_domain' => 'form',
            )
        );

    }

    public function getName()
    {
        return 'obbml_encounter_step1';
    }
}
