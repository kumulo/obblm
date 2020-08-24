<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CoachRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=CoachRepository::class)
 * @UniqueEntity("email")
 */
class Coach implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = ['ROLE_USER'];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;


    /**
     * @Groups("user:write")
     * @SerializedName("password")
     * @Assert\NotBlank(groups={"create"})
     */
    private $plainPassword;

    /**
     * @ORM\OneToMany(targetEntity=Team::class, mappedBy="coach", orphanRemoval=true)
     */
    private $teams;

    /**
     * @ORM\OneToMany(targetEntity=League::class, mappedBy="owner")
     */
    private $admin_leagues;

    /**
     * @ORM\ManyToMany(targetEntity=Championship::class, mappedBy="managers")
     */
    private $managed_championships;

    public function __construct()
    {
        $this->teams = new ArrayCollection();
        $this->admin_leagues = new ArrayCollection();
        $this->managed_championships = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
            $team->setCoach($this);
        }

        return $this;
    }

    public function removeTeam(Team $team): self
    {
        if ($this->teams->contains($team)) {
            $this->teams->removeElement($team);
            // set the owning side to null (unless already changed)
            if ($team->getCoach() === $this) {
                $team->setCoach(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|League[]
     */
    public function getAdminLeagues(): Collection
    {
        return $this->admin_leagues;
    }

    public function addAdminLeague(League $adminLeague): self
    {
        if (!$this->admin_leagues->contains($adminLeague)) {
            $this->admin_leagues[] = $adminLeague;
            $adminLeague->setOwner($this);
        }

        return $this;
    }

    public function removeAdminLeague(League $adminLeague): self
    {
        if ($this->admin_leagues->contains($adminLeague)) {
            $this->admin_leagues->removeElement($adminLeague);
            // set the owning side to null (unless already changed)
            if ($adminLeague->getOwner() === $this) {
                $adminLeague->setOwner(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Championship[]
     */
    public function getManagedChampionships(): Collection
    {
        return $this->managed_championships;
    }

    public function addManagedChampionship(Championship $managedChampionship): self
    {
        if (!$this->managed_championships->contains($managedChampionship)) {
            $this->managed_championships[] = $managedChampionship;
            $managedChampionship->addManager($this);
        }

        return $this;
    }

    public function removeManagedChampionship(Championship $managedChampionship): self
    {
        if ($this->managed_championships->contains($managedChampionship)) {
            $this->managed_championships->removeElement($managedChampionship);
            $managedChampionship->removeManager($this);
        }

        return $this;
    }

    public function __toString() {
        return $this->email;
    }
}
