<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\VarDumper\VarDumper;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=TeamRepository::class)
 */
class Team
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
     * @ORM\ManyToOne(targetEntity=Coach::class, inversedBy="teams")
     * @ORM\JoinColumn(nullable=false)
     */
    private $coach;

    /**
     * @ORM\OneToMany(targetEntity=Game::class, mappedBy="home_team")
     */
    private $games_as_home;

    /**
     * @ORM\OneToMany(targetEntity=Game::class, mappedBy="visitor_team")
     */
    private $games_as_visitor;

    /**
     * @ORM\ManyToOne(targetEntity=Championship::class, inversedBy="teams")
     */
    private $championship;

    /**
     * @ORM\ManyToOne(targetEntity=Rule::class, inversedBy="teams")
     */
    private $rule;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $anthem;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $fluff;

    /**
     * @ORM\OneToMany(targetEntity=Player::class, mappedBy="team", orphanRemoval=true)
     */
    private $players;

    public function __construct()
    {
        $this->games_as_home = new ArrayCollection();
        $this->games_as_visitor = new ArrayCollection();
        $this->players = new ArrayCollection();
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

    public function getCoach(): ?Coach
    {
        return $this->coach;
    }

    public function setCoach(?Coach $coach): self
    {
        $this->coach = $coach;

        return $this;
    }

    /**
     * @return Collection|Game[]
     */
    public function getGamesAsHome(): Collection
    {
        return $this->games_as_home;
    }

    public function addGameAsHome(Game $game): self
    {
        if (!$this->games_as_home->contains($game)) {
            $this->games_as_home[] = $game;
            $game->setHomeTeam($this);
        }

        return $this;
    }

    public function removeGameAsHome(Game $game): self
    {
        if ($this->games_as_home->contains($game)) {
            $this->games_as_home->removeElement($game);
            // set the owning side to null (unless already changed)
            if ($game->getHomeTeam() === $this) {
                $game->setHomeTeam(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Game[]
     */
    public function getGamesAsVisitor(): Collection
    {
        return $this->games_as_visitor;
    }

    public function addGameAsVisitor(Game $game): self
    {
        if (!$this->games_as_visitor->contains($game)) {
            $this->games_as_visitor[] = $game;
            $game->setHomeTeam($this);
        }

        return $this;
    }

    public function removeGameAsVisitor(Game $game): self
    {
        if ($this->games_as_visitor->contains($game)) {
            $this->games_as_visitor->removeElement($game);
            // set the owning side to null (unless already changed)
            if ($game->getHomeTeam() === $this) {
                $game->setHomeTeam(null);
            }
        }

        return $this;
    }

    /**
     * @return ArrayCollection|Game[]
     */
    public function getGames(): ArrayCollection
    {
        return new ArrayCollection(array_merge(
            $this->games_as_home->toArray(),
            $this->games_as_visitor->toArray()
        ));
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

    public function getRule(): ?Rule
    {
        return $this->rule;
    }

    public function setRule(?Rule $rule): self
    {
        $this->rule = $rule;

        return $this;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addConstraint(new Assert\Callback('validate'));
    }

    public function validate(ExecutionContextInterface $context, $payload)
    {
        if (!($context->getValue()->getRule() || $context->getValue()->getChampionship()) ||
            $context->getValue()->getRule() && $context->getValue()->getChampionship()) {
            $context->buildViolation('You should choose a rule or a championship!')
                ->addViolation();
        }
    }

    public function getAnthem(): ?string
    {
        return $this->anthem;
    }

    public function setAnthem(?string $anthem): self
    {
        $this->anthem = $anthem;

        return $this;
    }

    public function getFluff(): ?string
    {
        return $this->fluff;
    }

    public function setFluff(?string $fluff): self
    {
        $this->fluff = $fluff;

        return $this;
    }

    /**
     * @return Collection|Player[]
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addPlayer(Player $player): self
    {
        if (!$this->players->contains($player)) {
            $this->players[] = $player;
            $player->setTeam($this);
        }

        return $this;
    }

    public function removePlayer(Player $player): self
    {
        if ($this->players->contains($player)) {
            $this->players->removeElement($player);
            // set the owning side to null (unless already changed)
            if ($player->getTeam() === $this) {
                $player->setTeam(null);
            }
        }

        return $this;
    }
}
