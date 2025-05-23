<?php

namespace App\Entity;

use App\Repository\CampaignRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


#[ORM\Entity(repositoryClass: CampaignRepository::class)]
#[UniqueEntity(fields: ['name'], message: "Ya existe esta campaña en la base de datos")]
class Campaign
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Name

    #[ORM\Column(length: 255, unique: true, nullable: false)]
    #[Assert\NotNull(message: 'El nomnbre es obligatorio')]
    #[Assert\NotBlank(message: 'El nombre es obligatoro')]
    #[Assert\Length(min: 3, max: 255)]

    private ?string $name = null;

    // Description

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Length(min: 5, minMessage: 'Se requiere un minimo de 5 caracteres en la descripcion')]
    private ?string $description = null;

    // Start 

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: false)]
    #[Assert\NotBlank(message: 'La fecha de inicio es obligatoria')]
    #[Assert\NotNull(message: 'La fecha es obligatoria')]
    #[Assert\Type(\DateTimeInterface::class, message: 'Error en el formato de fecha (YYYY-MM-DD)')]
    #[Assert\GreaterThan('2000-03-01', message: 'Se permiten fechas posterior a 2000-03-01')]             //todo: Cambiar por una constante
    private ?\DateTimeInterface $startDate = null;

    // End

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: false)]
    #[Assert\Type(\DateTimeInterface::class, message: 'Error en el formato de fecha (YYYY-MM-DD)')]
    #[Assert\NotNull(message: 'La fecha es obligatoria')]
    #[Assert\NotBlank(message: 'La fecha de fin es obligatoria')]
    #[Assert\GreaterThan(
        propertyPath: 'startDate',
        message: 'Fecha incorrecta. Debe ser despues de la fecha de inicio.'
    )]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\OneToMany(mappedBy: 'campaign', targetEntity: Influencer::class, cascade: ['persist'])]
    private Collection $influencers;


    // Constructor

    public function __construct()
    {
        $this->influencers = new ArrayCollection();
    }


    // Get and Setters


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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getInfluencers(): Collection
    {
        return $this->influencers;
    }
}
