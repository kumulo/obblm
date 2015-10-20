<?php

namespace BbLigueBundle\Services;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\DataCollectorTranslator;
use BbLigueBundle\Entity\Team;

class RulesService {

    private $em;
    private $translator;
    private $available_rules;

    public function __construct(EntityManager $entity_manager, $translator, $datas) {
        $this->em = $entity_manager;
        $this->translator = $translator;
        $this->available_rules = $datas;

        $rules = $this->em->getRepository('BbLigueBundle:Rule')->findAll();
        foreach($rules as $rule) $this->addRule($rule);
    }

    public function getRules() {
        return $this->available_rules;
    }

    public function getRulesForForm() {
        $rules = array();
        foreach($this->available_rules as $key => $rule) {
            if(is_object($rule)) {
                $rules[$rule->getRuleKey()] = $rule->getName();
            }
            else {
                $rules[$key] = $this->translator->trans('rules.' . $key . '.title', array(), 'rules');
            }
        }
        return $rules;
    }

    public function addRule($rule) {
        return $this->available_rules[$rule->getRuleKey()] = $rule;
    }
    public function getRule($key) {
        if(!isset($this->available_rules[$key])) {return false;}
        $rule = array();
        $available_rule = $this->available_rules[$key];
        if(is_object($available_rule)) {
            $rule['name'] = $available_rule->getName();
            $rule['rule'] = $available_rule->getRule();
        }
        else {
            $rule['rule'] = $available_rule;
            $rule['name'] = $this->translator->trans('rules.' . $key . '.title', array(), 'rules');
        }
        return $rule;
    }
}
