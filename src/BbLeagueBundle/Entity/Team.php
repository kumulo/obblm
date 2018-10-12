<?php
// src/BbLeagueBundle/Entity/Team.php

namespace BbLeagueBundle\Entity;

use BbLeagueBundle\Model\Team as BaseTeam;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="BbLeagueBundle\Repository\TeamRepository")
 * @ORM\Table(name="bbl_team")
 */
class Team extends BaseTeam
{

    protected $last_journey;

    /**
     * Get encounters
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    /*public function getEncounters() {
        $realencounters = new ArrayCollection();
        $encounters = array_merge(
            ($this->encounters) ? iterator_to_array($this->encounters) : array(),
            ($this->encounters_has_visitor) ? iterator_to_array($this->encounters_has_visitor) : array()
        );
        if($encounters) {
            foreach($encounters as $encounter) {
                $realencounters->add($encounter);
            }
            $criteria = Criteria::create()
                ->orderBy(array("id" => Criteria::ASC))
            ;
            return $realencounters->encountering($criteria);
        }
        return $realencounters;
    }*/
    public function getContestants()
    {
        $encounters = new ArrayCollection();
        /** @var Encounter $encounter */
        foreach ($this->encounters as $encounter) {
            $encounters->add(($encounter->getTeam() == $this) ? $encounter->getVisitor() : $encounter->getTeam());
        }

        return $encounters;
    }

    public function getLastJourney()
    {
        $this->getJourneys();
        return $this->getJourneys()->first();
    }

    public function getTeamJourney($requested_journey)
    {
        foreach($this->getJourneys() as $journey) {
            if($requested_journey == $journey->getJourney()) return $journey;
        }
        return $this->getLastJourney();
    }


    protected $abs_path;
    protected $web_path;

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'teams/';
    }

    public function getWebPath()
    {
        return null === $this->logo
            ? null
            : $this->web_path.$this->logo;
    }

    protected function getUploadRootDir($root_path)
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return $this->abs_path.$this->getUploadDir();
    }

    public function setAbsPath($abs_path) {
        $this->abs_path = $abs_path.$this->getUploadDir();
    }

    public function setWebPath($web_path) {
        $this->web_path = $web_path.$this->getUploadDir();
    }

    public function getStats()
    {
        $j = $this->journeys;

        $iterator = $j->getIterator();
        $iterator->uasort(function (TeamByJourney $a, TeamByJourney $b) {
            return ($a->getId() < $b->getId()) ? -1 : 1;
        });
        $r = array();
        foreach(iterator_to_array($iterator) as $journey) {
            $r[$journey->getJourney()->getId()] = $journey->toArray();
        }
        ksort($r);
        return $r;
    }

    public function getDashbordStats()
    {
        $j = $this->getStats();

        $r = array();
        foreach($j as $key => $journey) {
            $nj = array(
                'label' => $journey['name'],
                'value' => $journey['tr']
            );
            $r[] = $nj;
        }
        return $r;
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Gets file.
     *
     * @return UploadedFile $file
     */
    public function getFile()
    {
        return $this->file;
    }
    public function removeFile($file)
    {
        $file_path = $this->abs_path.'/'.$file;
        if(file_exists($file_path)) unlink($file_path);
    }
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }
        if($this->logo) {
            $this->removeFile($this->logo);
        }

        $fileName = $this->getId() . '-' . md5(uniqid()) . '.' . $this->getFile()->guessExtension();
        $this->getFile()->move(
            $this->abs_path,
            $fileName
        );

        $this->logo = $fileName;
        $this->file = null;
    }
}
