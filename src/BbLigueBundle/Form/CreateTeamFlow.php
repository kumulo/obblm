<?php

namespace BbLigueBundle\Form;

use Craue\FormFlowBundle\Form\FormFlow;
use Craue\FormFlowBundle\Form\FormFlowInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use BbLigueBundle\Form\Type\TeamStep1;
use BbLigueBundle\Form\Type\TeamStep2;

class CreateTeamFlow extends FormFlow {

    public function getName() {
        return 'createTeam';
    }

    protected function loadStepsConfig() {
        return array(
            array(
                'label' => 'base',
                'form_type' => new TeamStep1(),
            ),
            array(
                'label' => 'roster_and_conf',
                'form_type' => new TeamStep2(),
            ),
            array(
                'label' => 'confirmation',
            ),
        );
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BbLigueBundle\Entity\Team',
            'translation_domain' => 'form'
        ));

    }

}
