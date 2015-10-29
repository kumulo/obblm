<?php
// src/BbLigueBundle/Entity/Rule.php

namespace BbLigueBundle\Entity;

use BbLigueBundle\Model\Rule as BaseRule;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="bbl_rule")
 */
class Rule extends BaseRule
{
    protected $injury_table = array();

    /**
     * Set rule
     *
     * @param array $rule
     *
     * @return Rule
     */
    public function setRule($rule) {
        parent::setRule($rule);
        $this->constructInjuryTable($rule);

        return $this;
    }

    /**
     * Construct Injury Table
     *
     * @param array $rule
     *
     */
    protected function constructInjuryTable($rule) {
        foreach($rule['injuries'] as $injury_key => $injury) {
            if(isset($injury['from']) && isset($injury['to'])) {
                for($key = $injury['from']; $key <= $injury['to']; $key++) {
                    $this->injury_table[$key] = $injury_key;
                }
            }
            elseif(isset($injury['from'])) {
                $this->injury_table[$injury['from']] = $injury_key;
            }
        }
    }

    /**
     * Get Max Team Cost
     *
     * @return integer
     */
    public function getMaxTeamCost() {
        $datas = $this->getRule();
        return ($datas['max_team_cost']) ? $datas['max_team_cost'] : 0;
    }
    /**
     * Get Experience Level For Experience Value
     *
     * @param integer $experience
     *
     * @return string
     */
    public function getExperienceLevelForValue($experience) {
        $datas = $this->getRule();
        ksort($datas['experience']);
        $last = false;
        foreach($datas['experience'] as $key => $level) {
            if($experience >= $key) $last = $level;
        }
        return $last;
    }

    /**
     * Get Injury For Value
     *
     * @param integer $value
     *
     * @return array
     */
    public function getInjury($value) {
        return (isset($this->injury_table[$value])) ? array(
            'key_name' => $this->injury_table[$value],
            'effect' => $this->getInjuryEffect($this->injury_table[$value])
        ) : false ;
    }

    /**
     * Get Injury Effect For Injury Key Name
     *
     * @param string $key_name
     *
     * @return array
     */
    public function getInjuryEffect($key_name) {
        $datas = $this->getRule();
        return ($datas['injuries'][$key_name]) ? $datas['injuries'][$key_name]['effects'] : false;
    }
}
