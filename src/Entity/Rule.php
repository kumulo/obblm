<?php

namespace App\Entity;

use App\Repository\RuleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RuleRepository::class)
 */
class Rule
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true, length=255)
     */
    private $rule_key;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $rule = [];

    /**
     * @ORM\Column(type="boolean")
     */
    private $post_bb_2020;

    /**
     * @ORM\Column(type="boolean")
     */
    private $read_only;

    /**
     * @ORM\OneToMany(targetEntity=Team::class, mappedBy="rule")
     */
    private $teams;

    /**
     * @ORM\OneToMany(targetEntity=Championship::class, mappedBy="rule", orphanRemoval=true)
     */
    private $championships;

    public function __construct() {
        $this->post_bb_2020 = false;
        $this->read_only = false;
        $this->championships = new ArrayCollection();
        $this->teams = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRuleKey(): ?string
    {
        return $this->rule_key;
    }

    public function setRuleKey(string $rule_key): self
    {
        $this->rule_key = $rule_key;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getRule(): ?array
    {
        return $this->rule;
    }

    public function setRule(?array $rule): self
    {
        $this->rule = $rule;

        return $this;
    }

    public function getPostBb2020(): ?bool
    {
        return $this->post_bb_2020;
    }

    public function isPostBb2020(): ?bool
    {
        return $this->getPostBb2020();
    }

    public function setPostBb2020(bool $post_bb_2020): self
    {
        $this->post_bb_2020 = $post_bb_2020;

        return $this;
    }

    public function getReadOnly(): ?bool
    {
        return $this->read_only;
    }

    public function isReadOnly(): ?bool
    {
        return $this->getReadOnly();
    }

    public function setReadOnly(bool $read_only): self
    {
        $this->read_only = $read_only;

        return $this;
    }

    /**
     * @return Collection|Team[]
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): self
    {
        if (!$this->teams->contains($team)) {
            $this->teams[] = $team;
            $team->setRule($this);
        }

        return $this;
    }

    public function removeTeam(Team $team): self
    {
        if ($this->teams->contains($team)) {
            $this->teams->removeElement($team);
            // set the owning side to null (unless already changed)
            if ($team->getRule() === $this) {
                $team->setRule(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Championship[]
     */
    public function getChampionships(): Collection
    {
        return $this->championships;
    }

    public function addChampionship(Championship $championship): self
    {
        if (!$this->championships->contains($championship)) {
            $this->championships[] = $championship;
            $championship->setRule($this);
        }

        return $this;
    }

    public function removeChampionship(Championship $championship): self
    {
        if ($this->championships->contains($championship)) {
            $this->championships->removeElement($championship);
            // set the owning side to null (unless already changed)
            if ($championship->getRule() === $this) {
                $championship->setRule(null);
            }
        }

        return $this;
    }
}
