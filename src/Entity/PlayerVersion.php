<?php

namespace App\Entity;

use App\Repository\PlayerVersionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlayerVersionRepository::class)
 */
class PlayerVersion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Player::class, inversedBy="versions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $player;

    /**
     * @ORM\Column(type="array")
     */
    private $characteristics = [];

    /**
     * @ORM\Column(type="array")
     */
    private $skills = [];

    /**
     * @ORM\Column(type="array")
     */
    private $injuries = [];

    /**
     * @ORM\Column(type="integer")
     */
    private $value;

    /**
     * @ORM\Column(type="boolean")
     */
    private $dead;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $actions = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(?Player $player): self
    {
        $this->player = $player;

        return $this;
    }

    public function getCharacteristics(): ?array
    {
        return $this->characteristics;
    }

    public function setCharacteristics(array $characteristics): self
    {
        $this->characteristics = $characteristics;

        return $this;
    }

    public function getSkills(): ?array
    {
        return $this->skills;
    }

    public function setSkills(array $skills): self
    {
        $this->skills = $skills;

        return $this;
    }

    public function getInjuries(): ?array
    {
        return $this->injuries;
    }

    public function setInjuries(array $injuries): self
    {
        $this->injuries = $injuries;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getDead(): ?bool
    {
        return $this->dead;
    }

    public function setDead(bool $dead): self
    {
        $this->dead = $dead;
        $this->getPlayer()->setDead($this->dead);
        return $this;
    }

    public function getActions(): ?array
    {
        return $this->actions;
    }

    public function setActions(?array $actions): self
    {
        $this->actions = $actions;

        return $this;
    }
}
