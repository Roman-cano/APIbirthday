<?php

namespace App\Entity;
use App\Entity\Birthday;
use JMS\Serializer\Annotation as JMS;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;


use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @JMS\Groups({"birthday_detail"})
 */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @JMS\Groups({"birthday_detail"})
 */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @JMS\Groups({"birthday_detail"})
 */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @JMS\Groups({"birthday_detail"})
 */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @JMS\Groups({"birthday_detail"})
 */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @JMS\Groups({"birthday_detail"})
 */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity=birthday::class, mappedBy="auser")
     * @JMS\Groups({"birthday_detail"})
 */
    private $birthday;

    public function __construct()
    {
        $this->birthday = new ArrayCollection();
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
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
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
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Birthday>
     */
    public function getBirthday(): Collection
    {
        return $this->birthday;
    }

    public function addBirthday(Birthday $birthday): self
    {
        if (!$this->birthday->contains($birthday)) {
            $this->birthday[] = $birthday;
            $birthday->setAuser($this);
        }

        return $this;
    }

    public function removeBirthday(Birthday $birthday): self
    {
        if ($this->birthday->removeElement($birthday)) {
            // set the owning side to null (unless already changed)
            if ($birthday->getAuser() === $this) {
                $birthday->setAuser(null);
            }
        }

        return $this;
    }
}
