<?php

namespace BbLeagueBundle\Services\TieBreaks;

use Doctrine\ORM\QueryBuilder;

interface TieBreakInterface
{
    public function __construct($options = []);
    /*
     * Function to use to update the query
     */
    public function updateTieBreakQuery(QueryBuilder $query);
    /*
     * Function to get the name in translations
     */
    public function getName();
    /*
     * Function to get the name in translations
     */
    public function getClassName();
}
