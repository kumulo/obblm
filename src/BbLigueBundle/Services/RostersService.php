<?php

namespace BbLigueBundle\Services;


class RostersService {
    
    private $available_rosters;
    
    public function __construct($datas) {
        
        $this->available_rosters = $datas;
    }
    
    public function getRosters() {
        return $this->available_rosters;
    }
}