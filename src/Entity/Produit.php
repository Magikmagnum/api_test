<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 */
class Produit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups("produit:list")
     * @Groups("produit:show")
     */
    private $idt;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("produit:list")
     * @Groups("produit:show")
     * @Assert\NotBlank
     * @Assert\Type(
     *     type="alnum",
     *     message="Champ invalide."
     * )
     */
    private $nom;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups("produit:show")
     * @Groups("produit:list")
     * @Assert\Type(
     *     type="integer",
     *     message="Champ invalide."
     * )
     */
    private $quantite;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="produits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getIdt(): ?string
    {
        return $this->idt;
    }

    public function setIdt(string $id): self
    {
        $this->idt = $id;
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

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(?int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
