<?php

namespace App\Service;

use App\Service\ChampionshipFormat\ChampionshipFormatInterface;
use Doctrine\Common\Collections\ArrayCollection;
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

    public function getFormat($key)
    {
        if (!isset($this->formats[$key])) {
            return false;
        }

        return $this->formats[$key];
    }

    public function addFormat(ChampionshipFormatInterface $championshipFormat) {
        $this->formats->offsetSet($championshipFormat->getFormat(), $championshipFormat);
    }
}
