<?php

namespace App\Entity;

use App\Repository\BirthdayRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation as JMS;  // Assure-toi que cette ligne est présente

use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass=BirthdayRepository::class)
 */
class Birthday
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @JMS\Groups({"birthday_detail"})
 */
    private $id;

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
     * @ORM\Column(type="date")
     * @JMS\Groups({"birthday_detail"})
     */
    private $anniversaire;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="birthday")
     * @JMS\Groups({"birthday_detail"})
     */
    private $auser;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAnniversaire(): ?\DateTimeInterface
    {
        return $this->anniversaire;
    }

    public function setAnniversaire(\DateTimeInterface $anniversaire): self
    {
        $this->anniversaire = $anniversaire;

        return $this;
    }

    public function getAuser(): ?User
    {
        return $this->auser;
    }

    public function setAuser(?User $auser): self
    {
        $this->auser = $auser;

        return $this;
    }
}
