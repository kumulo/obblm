<?php

namespace BbLeagueBundle\Services\TieBreaks;

use Doctrine\ORM\EntityManager;

interface TieBreakInterface
{
    public function __construct (EntityManager $em);
    /*
     * Function to use to update the query
     */
    public function updateTieBreakQuery ($query);
    /*
     * Function to get the name in translations
     */
    public function getName();
    /*
     * Function to get the name in translations
     */
    public function getClassName();
}
