<?php

namespace BBlm\Service;

use BBlm\Entity\Championship;
use BBlm\Service\ChampionshipFormat\ChampionshipFormatInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use Symfony\Component\Form\Exception\UnexpectedTypeException;

class ChampionshipService {

    private $formats;

    public function __construct() {
        $this->formats = new ArrayCollection();
    }

    public function getFormats():ArrayCollection {
        return $this->formats;
    }

    public function getFormatsForForm():array {
        $formats = [];
        foreach ($this->formats as $key => $format) {
            if(!$format instanceof ChampionshipFormatInterface) {
                throw new UnexpectedTypeException($format, ChampionshipFormatInterface::class);
            }
            $tiebreaks[$key] = $format->getKey();
        }
        return $formats;
    }

    public function getFormat($key):ChampionshipFormatInterface
    {
        if (!isset($this->formats[$key])) {
            throw new Exception("Unkown format " . $key);
        }

        return $this->formats[$key];
    }

    public function addFormat(ChampionshipFormatInterface $championshipFormat) {
        $this->formats->offsetSet($championshipFormat->getFormat(), $championshipFormat);
    }

    public static function getFreeOfEncountersTeams(Championship $championship):array {
        $teams = [];
        foreach($championship->getTeams() as $team) {
            if(TeamService::isFreeOfEncounter($team)) $teams[] = $team;
        }
        return $teams;
    }
}
