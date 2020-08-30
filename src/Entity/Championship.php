<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ChampionshipRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ChampionshipRepository::class)
 */
class Championship
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=League::class, inversedBy="championships")
     * @ORM\JoinColumn(nullable=false)
     */
    private $league;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $format;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tie_break_1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tie_break_2;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tie_break_3;

    /**
     * @ORM\Column(type="boolean")
     */
    private $auto_validate_games = false;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $number_of_journeys;

    /**
     * @ORM\OneToMany(targetEntity=Journey::class, mappedBy="championship", orphanRemoval=true)
     */
    private $journeys;

    /**
     * @ORM\OneToMany(targetEntity=Game::class, mappedBy="championship", orphanRemoval=true)
     */
    private $games;

    /**
     * @ORM\OneToMany(targetEntity=Team::class, mappedBy="championship")
     */
    private $teams;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_private = false;

    /**
     * @ORM\ManyToMany(targetEntity=Coach::class, inversedBy="managed_championships")
     * @ORM\JoinTable(name="championship_manager")
     */
    private $managers;

    /**
     * @ORM\ManyToOne(targetEntity=Rule::class, inversedBy="championships")
     * @ORM\JoinColumn(nullable=false)
     */
    private $rule;

    /**
     * @ORM\Column(type="integer")
     */
    private $max_teams;

    /**
     * @ORM\OneToMany(targetEntity=ChampionshipInvitation::class, mappedBy="championship", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $invitations;

    /**
     * @ORM\ManyToMany(targetEntity=Coach::class, inversedBy="championships")
     */
    private $guests;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_locked = false;

    public function __construct()
    {
        $this->journeys = new ArrayCollection();
        $this->games = new ArrayCollection();
        $this->teams = new ArrayCollection();
        $this->managers = new ArrayCollection();
        $this->invitations = new ArrayCollection();
        $this->guests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLeague(): ?League
    {
        return $this->league;
    }

    public function setLeague(?League $league): self
    {
        $this->league = $league;

        return $this;
    }

    public function getFormat(): ?string
    {
        return $this->format;
    }

    public function setFormat(string $format): self
    {
        $this->format = $format;

        return $this;
    }

    public function getTieBreak1(): ?string
    {
        return $this->tie_break_1;
    }

    public function setTieBreak1(string $tie_break_1): self
    {
        $this->tie_break_1 = $tie_break_1;

        return $this;
    }

    public function getTieBreak2(): ?string
    {
        return $this->tie_break_2;
    }

    public function setTieBreak2(string $tie_break_2): self
    {
        $this->tie_break_2 = $tie_break_2;

        return $this;
    }

    public function getTieBreak3(): ?string
    {
        return $this->tie_break_3;
    }

    public function setTieBreak3(string $tie_break_3): self
    {
        $this->tie_break_3 = $tie_break_3;

        return $this;
    }

    public function getAutoValidateGames(): ?bool
    {
        return $this->auto_validate_games;
    }

    public function setAutoValidateGames(bool $auto_validate_games): self
    {
        $this->auto_validate_games = $auto_validate_games;

        return $this;
    }

    public function getNumberOfJourneys(): ?int
    {
        return $this->number_of_journeys;
    }

    public function setNumberOfJourneys(?int $number_of_journeys): self
    {
        $this->number_of_journeys = $number_of_journeys;

        return $this;
    }

    /**
     * @return Collection|Journey[]
     */
    public function getJourneys(): Collection
    {
        return $this->journeys;
    }

    public function addJourney(Journey $journey): self
    {
        if (!$this->journeys->contains($journey)) {
            $this->journeys[] = $journey;
            $journey->setChampionship($this);
        }

        return $this;
    }

    public function removeJourney(Journey $journey): self
    {
        if ($this->journeys->contains($journey)) {
            $this->journeys->removeElement($journey);
            // set the owning side to null (unless already changed)
            if ($journey->getChampionship() === $this) {
                $journey->setChampionship(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Game[]
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): self
    {
        if (!$this->games->contains($game)) {
            $this->games[] = $game;
            $game->setChampionship($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->games->contains($game)) {
            $this->games->removeElement($game);
            // set the owning side to null (unless already changed)
            if ($game->getChampionship() === $this) {
                $game->setChampionship(null);
            }
        }

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
            $team->setChampionship($this);
        }

        return $this;
    }

    public function removeTeam(Team $team): self
    {
        if ($this->teams->contains($team)) {
            $this->teams->removeElement($team);
            // set the owning side to null (unless already changed)
            if ($team->getChampionship() === $this) {
                $team->setChampionship(null);
            }
        }

        return $this;
    }

    public function isPrivate(): ?bool
    {
        return $this->is_private;
    }

    public function getIsPrivate(): ?bool
    {
        return $this->is_private;
    }

    public function setIsPrivate(bool $is_private): self
    {
        $this->is_private = $is_private;

        return $this;
    }

    /**
     * @return Collection|Coach[]
     */
    public function getManagers(): Collection
    {
        return $this->managers;
    }

    public function addManager(Coach $manager): self
    {
        if (!$this->managers->contains($manager)) {
            $this->managers[] = $manager;
        }

        return $this;
    }

    public function removeManager(Coach $manager): self
    {
        if ($this->managers->contains($manager)) {
            $this->managers->removeElement($manager);
        }

        return $this;
    }

    public function isLocked(): ?bool
    {
        return $this->is_locked;
    }

    public function getIsLocked(): ?bool
    {
        return $this->is_locked;
    }

    public function setIsLocked(bool $is_locked): self
    {
        $this->is_locked = $is_locked;

        return $this;
    }

    public function getRule(): ?Rule
    {
        return $this->rule;
    }

    public function setRule(?Rule $rule): self
    {
        $this->rule = $rule;

        return $this;
    }

    public function getMaxTeams(): ?int
    {
        return $this->max_teams;
    }

    public function setMaxTeams(int $max_teams): self
    {
        $this->max_teams = $max_teams;

        return $this;
    }

    /**
     * @return Collection|ChampionshipInvitation[]
     */
    public function getInvitations(): Collection
    {
        return $this->invitations;
    }

    public function addInvitation(ChampionshipInvitation $invitation): self
    {
        if (!$this->invitations->contains($invitation)) {
            $this->invitations[] = $invitation;
            $invitation->setChampionship($this);
        }

        return $this;
    }

    public function removeInvitation(ChampionshipInvitation $invitation): self
    {
        if ($this->invitations->contains($invitation)) {
            $this->invitations->removeElement($invitation);
            // set the owning side to null (unless already changed)
            if ($invitation->getChampionship() === $this) {
                $invitation->setChampionship(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Coach[]
     */
    public function getGuests(): Collection
    {
        return $this->guests;
    }

    public function addGuest(Coach $guest): self
    {
        if (!$this->guests->contains($guest)) {
            $this->guests[] = $guest;
        }

        return $this;
    }

    public function removeGuest(Coach $guest): self
    {
        if ($this->guests->contains($guest)) {
            $this->guests->removeElement($guest);
        }

        return $this;
    }
}