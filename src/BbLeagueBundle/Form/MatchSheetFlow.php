<?php

namespace BbLeagueBundle\Form;

use Craue\FormFlowBundle\Form\FormFlow;
use Symfony\Component\OptionsResolver\OptionsResolver;

use BbLeagueBundle\Form\Type\MatchStep1;
use BbLeagueBundle\Form\Type\MatchStep2;
use BbLeagueBundle\Form\Type\MatchStep3;
use BbLeagueBundle\Services\RulesService;
use BbLeagueBundle\Services\LeagueService;

class MatchSheetFlow extends FormFlow {

    private $rule_service;
    private $translator;

    public function __construct($translator, RulesService $service)
    {
        $this->translator = $translator;
        $this->rule_service = $service;
    }
    public function getName() {
        return 'matchSheet';
    }

    protected function loadStepsConfig() {
        return array(
            array(
                'label' => 'form.encounter.sheet.steps.step1.title',
                'form_type' => new MatchStep1($this->translator, $this->league_service),
            ),
            array(
                'label' => 'form.encounter.sheet.steps.step2.title',
                'form_type' => new MatchStep2($this->translator, $this->league_service),
                'form_options' => array(
                    'validation_groups' => array('Default'),
                ),
            ),
            array(
                'label' => 'form.encounter.sheet.steps.step3.title',
                'form_type' => new MatchStep3($this->translator, $this->league_service),
                'form_options' => array(
                    'validation_groups' => array('Default'),
                ),
            ),
            array(
                'label' => 'form.encounter.sheet.steps.step4.title',
            ),
        );
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BbLeagueBundle\Entity\Match',
            'translation_domain' => 'form'
        ));

    }

}
