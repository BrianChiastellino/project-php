<?php

namespace App\Entity;

use App\Repository\InfluencerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


#[ORM\Entity(repositoryClass: InfluencerRepository::class)]
// #[UniqueEntity(fields: ['name', 'email'], message:'Ya existe influencer en base de datos')] --> De esta forma tienen que ser los dos iguales.

#[UniqueEntity(fields: ['name'], message: 'Ya existe influencer en base de datos' )]
#[UniqueEntity(fields: ['email'], message: 'Ya existe influencer en base de datos' )]
class Influencer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Name

    #[ORM\Column(length: 255, unique: true, nullable: false)]
    #[Assert\NotNull(message: 'El nombre es obligatorio')]
    #[Assert\NotBlank(message: 'El nombre es obligatorio')]
    #[Assert\Length(min: 3, max: 255)]
    private ?string $name = null;

    // Email

    #[ORM\Column(length: 255, unique: true, nullable: false)]
    #[Assert\Email(message: 'Formato de email invalido')]
    #[Assert\NotNull(message: 'El email es obligatorio')]
    #[Assert\NotBlank(message: 'El email es obligatorio')]
    #[Assert\Length(min: 3, max: 255)]
    private ?string $email = null;

    // Followers

    #[ORM\Column]
    #[Assert\NotNull(message: 'La cantidad de seguidores es obligatoria')]
    #[Assert\Type(type: 'integer', message: 'Ingrese un numero entero')]
    #[Assert\GreaterThanOrEqual(value: 0, message: 'Ingrese un numero correcto de seguidores')]
    private ?int $followersCount = 0;

    // Relacion 

    #[ORM\ManyToOne(targetEntity: Campaign::class, inversedBy: 'influencers')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Campaign $campaign = null;

    // Geters and Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getFollowersCount(): ?int
    {
        return $this->followersCount;
    }

    public function setFollowersCount(int $followersCount): static
    {
        $this->followersCount = $followersCount;

        return $this;
    }

    public function getCampaignInfo(): ?string
    {
        if (null === $this->campaign) {
            return null;
        }

        return sprintf(
            '%d – %s',
            $this->campaign->getId(),
            $this->campaign->getName()
        );
    }

    public function setCampaign(?Campaign $campaign): self
    {
        $this->campaign = $campaign;
        return $this;
    }
}
