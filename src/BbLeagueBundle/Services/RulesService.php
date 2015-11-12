<?php

namespace BbLeagueBundle\Services;
use Doctrine\ORM\EntityManager;

class RulesService {

    private $em;
    private $translator;
    private $available_rules;

    public function __construct(EntityManager $entity_manager, $translator, $datas) {
        $this->em = $entity_manager;
        $this->translator = $translator;

        foreach($datas as $name => $rule) $this->addStaticRule($name, $rule);
        $rules = $this->em->getRepository('BbLeagueBundle:Rule')->findAll();
        foreach($rules as $rule) $this->addRule($rule);
    }

    public function getRules() {
        return $this->available_rules;
    }

    public function getRulesForForm() {
        $rules = array();
        foreach($this->available_rules as $key => $rule) {
            if($rule->getId()) {
                $rules[$rule->getRuleKey()] = $rule->getName();
            }
            else {
                $rules[$key] = $this->translator->trans('rules.' . $key . '.title', array(), 'rules');
            }
        }
        return $rules;
    }

    public function addStaticRule($name, Array $data) {
        $rule = new \BbLeagueBundle\Entity\Rule();
        $rule->setRule($data);
        $rule->setRuleKey($name);
        $rule->setName($this->translator->trans('rules.' . $name . '.title', array(), 'rules'));
        $this->available_rules[$rule->getRuleKey()] = $rule;
    }

    public function addRule(\BbLeagueBundle\Entity\Rule $rule) {
        $this->available_rules[$rule->getRuleKey()] = $rule;
    }
    public function getRule($key) {
        return (isset($this->available_rules[$key])) ? $this->available_rules[$key] : false;
    }
}
