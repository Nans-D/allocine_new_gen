<?php

namespace App\Entity;

use App\Repository\UserMoodRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserMoodRepository::class)]
class UserMood
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userMoods')]
    private ?Users $user_id = null;

    #[ORM\ManyToOne(inversedBy: 'userMoods')]
    private ?Moods $mood_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?Users
    {
        return $this->user_id;
    }

    public function setUserId(?Users $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getMoodId(): ?Moods
    {
        return $this->mood_id;
    }

    public function setMoodId(?Moods $mood_id): static
    {
        $this->mood_id = $mood_id;

        return $this;
    }
}
