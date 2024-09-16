<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    /**
     * @var Collection<int, Reviews>
     */
    #[ORM\OneToMany(targetEntity: Reviews::class, mappedBy: 'user_id')]
    private Collection $reviews;

    /**
     * @var Collection<int, UserMood>
     */
    #[ORM\OneToMany(targetEntity: UserMood::class, mappedBy: 'user_id')]
    private Collection $userMoods;

    /**
     * @var Collection<int, MoviePlaylists>
     */
    #[ORM\OneToMany(targetEntity: MoviePlaylists::class, mappedBy: 'user_id')]
    private Collection $moviePlaylists;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
        $this->userMoods = new ArrayCollection();
        $this->moviePlaylists = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection<int, Reviews>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Reviews $review): static
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews->add($review);
            $review->setUserId($this);
        }

        return $this;
    }

    public function removeReview(Reviews $review): static
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getUserId() === $this) {
                $review->setUserId(null);
            }
        }

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
            $userMood->setUserId($this);
        }

        return $this;
    }

    public function removeUserMood(UserMood $userMood): static
    {
        if ($this->userMoods->removeElement($userMood)) {
            // set the owning side to null (unless already changed)
            if ($userMood->getUserId() === $this) {
                $userMood->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MoviePlaylists>
     */
    public function getMoviePlaylists(): Collection
    {
        return $this->moviePlaylists;
    }

    public function addMoviePlaylist(MoviePlaylists $moviePlaylist): static
    {
        if (!$this->moviePlaylists->contains($moviePlaylist)) {
            $this->moviePlaylists->add($moviePlaylist);
            $moviePlaylist->setUserId($this);
        }

        return $this;
    }

    public function removeMoviePlaylist(MoviePlaylists $moviePlaylist): static
    {
        if ($this->moviePlaylists->removeElement($moviePlaylist)) {
            // set the owning side to null (unless already changed)
            if ($moviePlaylist->getUserId() === $this) {
                $moviePlaylist->setUserId(null);
            }
        }

        return $this;
    }
}
