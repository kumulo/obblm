<?php

namespace App\Service;
use App\Entity\Rule;
use Doctrine\ORM\EntityManagerInterface;

class RuleService {

    const TRANSLATION_GLUE = '.';

    private $em;
    private $translator;
    private $available_rules;

    public function __construct(EntityManagerInterface $em, $translator, $datas) {
        $this->em = $em;
        $this->translator = $translator;

        foreach($datas as $name => $rule) $this->addStaticRule($name, $rule);
        $rules = $this->em->getRepository(Rule::class)->findAll();
        foreach($rules as $rule) $this->addRule($rule);
    }

    public function getRules() {
        return $this->available_rules;
    }

    public function getRulesForForm() {
        $rules = array();
        foreach($this->available_rules as $key => $rule) {
            if($rule->getId()) {
                $rules[$rule->getName()] = $rule->getRuleKey();
            }
            else {
                $rules[$this->translator->trans('rules.' . $key . '.title', array(), 'rules')] = $key;
            }
        }
        return $rules;
    }

    public function addStaticRule($name, Array $data) {
        $rule = (new Rule())
            ->setRule($data)
            ->setRuleKey($name)
            ->setName($this->translator->trans('rules.' . $name . '.title', array(), 'rules'));
        $this->available_rules[$rule->getRuleKey()] = $rule;
    }

    public function addRule(Rule $rule) {
        $this->available_rules[$rule->getRuleKey()] = $rule;
    }
    public function getRule($key) {
        return (isset($this->available_rules[$key])) ? $this->available_rules[$key] : false;
    }

    public static function composeTranslationRosterKey($rule_key, $roster):string {
        return join(self::TRANSLATION_GLUE, [$rule_key, 'rosters', $roster, 'title']);
    }

    public static function getAvailableRosters(Rule $object):array {
        $rule = $object->getRule();

        return array_keys($rule['rosters']);
    }
}
