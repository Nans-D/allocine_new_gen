<?php

namespace App\Entity;

use App\Repository\MoodsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MoodsRepository::class)]
class Moods
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<int, UserMood>
     */
    #[ORM\OneToMany(targetEntity: UserMood::class, mappedBy: 'mood_id')]
    private Collection $userMoods;

    public function __construct()
    {
        $this->userMoods = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, UserMood>
     */
    public function getUserMoods(): Collection
    {
        return $this->userMoods;
    }

    public function addUserMood(UserMood $userMood): static
    {
        if (!$this->userMoods->contains($userMood)) {
            $this->userMoods->add($userMood);
            $userMood->setMoodId($this);
        }

        return $this;
    }

    public function removeUserMood(UserMood $userMood): static
    {
        if ($this->userMoods->removeElement($userMood)) {
            // set the owning side to null (unless already changed)
            if ($userMood->getMoodId() === $this) {
                $userMood->setMoodId(null);
            }
        }

        return $this;
    }
}
