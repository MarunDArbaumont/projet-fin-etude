<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: "users")]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Email]
    private string $email;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\Column(type: 'string')]
    private string $password;
    
    #[ORM\Column(type: 'string', length: 100)]
    #[Assert\NotBlank]
    private string $name;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $bio = null;

    #[ORM\Column(type: 'boolean', options: ['default' => true])]
    private bool $firstLogin = true;

    #[ORM\ManyToMany(targetEntity: Manga::class)]
    #[ORM\JoinTable(name: 'user_manga')]
    private Collection $mangas;

    public function getId(): ?int { return $this->id; }
    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): self { $this->email = $email; return $this; }

    public function getRoles(): array {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }
    public function setRoles(array $roles): self {
        $this->roles = $roles;
        return $this;
    }
    

    public function getPassword(): string { return $this->password; }
    public function setPassword(string $password): self { $this->password = $password; return $this; }

    public function getName(): string { return $this->name; }
    public function setName(string $name): self { $this->name = $name; return $this; }

    public function eraseCredentials():void {}
    public function getUserIdentifier(): string { return $this->email; }
    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): self
    {
        $this->bio = $bio;
        return $this;
    }

    public function getFirstLogin(): bool
    {
        return $this->firstLogin;
    }

    public function setFirstLogin(bool $firstLogin): self
    {
        $this->firstLogin = $firstLogin;

        return $this;
    }
    
    public function __construct()
    {
        $this->mangas = new ArrayCollection();
    }

    public function getMangas(): Collection
    {
        return $this->mangas;
    }

    public function addManga(Manga $manga): self
    {
        if (!$this->mangas->contains($manga)) {
            $this->mangas[] = $manga;
        }

        return $this;
    }

    public function removeManga(Manga $manga): self
    {
        $this->mangas->removeElement($manga);

        return $this;
    }
}
