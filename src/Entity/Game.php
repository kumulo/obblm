<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GameRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=GameRepository::class)
 */
class Game
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $validated_at;

    /**
     * @ORM\ManyToOne(targetEntity=Championship::class, inversedBy="games")
     * @ORM\JoinColumn(nullable=false)
     */
    private $championship;

    /**
     * @ORM\ManyToOne(targetEntity=Journey::class, inversedBy="games")
     */
    private $journey;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class, inversedBy="games")
     * @ORM\JoinColumn(nullable=false)
     */
    private $home_team;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class, inversedBy="games")
     * @ORM\JoinColumn(nullable=false)
     */
    private $visitor_team;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getValidatedAt(): ?\DateTimeInterface
    {
        return $this->validated_at;
    }

    public function setValidatedAt(?\DateTimeInterface $validated_at): self
    {
        $this->validated_at = $validated_at;

        return $this;
    }

    public function getChampionship(): ?Championship
    {
        return $this->championship;
    }

    public function setChampionship(?Championship $championship): self
    {
        $this->championship = $championship;

        return $this;
    }

    public function getJourney(): ?Journey
    {
        return $this->journey;
    }

    public function setJourney(?Journey $journey): self
    {
        $this->journey = $journey;

        return $this;
    }

    public function getHomeTeam(): ?Team
    {
        return $this->home_team;
    }

    public function setHomeTeam(?Team $home_team): self
    {
        $this->home_team = $home_team;

        return $this;
    }

    public function getVisitorTeam(): ?Team
    {
        return $this->visitor_team;
    }

    public function setVisitorTeam(?Team $visitor_team): self
    {
        $this->visitor_team = $visitor_team;

        return $this;
    }
}
