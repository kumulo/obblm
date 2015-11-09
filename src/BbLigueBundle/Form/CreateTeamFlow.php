<?php

namespace BbLigueBundle\Form;

use Craue\FormFlowBundle\Form\FormFlow;
use Craue\FormFlowBundle\Form\FormFlowInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use BbLigueBundle\Form\Type\TeamStep1;
use BbLigueBundle\Form\Type\TeamStep2;
use BbLigueBundle\Services\RulesService;

class CreateTeamFlow extends FormFlow {

    private $rules;
    private $translator;

    public function __construct($translator, RulesService $service)
    {
        $this->translator = $translator;
        $this->rules = $service;
    }
    public function getName() {
        return 'createTeam';
    }

    protected function loadStepsConfig() {
        return array(
            array(
                'label' => 'form.team.add.steps.step1.title',
                'form_type' => new TeamStep1(),
            ),
            array(
                'label' => 'form.team.add.steps.step2.title',
                'form_type' => new TeamStep2($this->translator, $this->rules),
            ),
            array(
                'label' => 'form.team.add.steps.step3.title',
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
