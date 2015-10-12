<?php

namespace BbLigueBundle\Services;


class RostersService {
    
    private $available_rules;
    
    public function __construct($datas) {
        
        $this->available_rules = $datas;
    }
    
    public function getRules() {
        return $this->available_rules;
    }

    public function addRule($rule) {
        return $this->available_rules[] = $rules;
    }
}
