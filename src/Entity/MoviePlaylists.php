<?php

namespace App\Entity;

use App\Repository\MoviePlaylistsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MoviePlaylistsRepository::class)]
class MoviePlaylists
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'moviePlaylists')]
    private ?Users $user_id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    /**
     * @var Collection<int, PlaylistMovies>
     */
    #[ORM\OneToMany(targetEntity: PlaylistMovies::class, mappedBy: 'playlist_id')]
    private Collection $playlistMovies;

    public function __construct()
    {
        $this->playlistMovies = new ArrayCollection();
    }

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
     * @return Collection<int, PlaylistMovies>
     */
    public function getPlaylistMovies(): Collection
    {
        return $this->playlistMovies;
    }

    public function addPlaylistMovie(PlaylistMovies $playlistMovie): static
    {
        if (!$this->playlistMovies->contains($playlistMovie)) {
            $this->playlistMovies->add($playlistMovie);
            $playlistMovie->setPlaylistId($this);
        }

        return $this;
    }

    public function removePlaylistMovie(PlaylistMovies $playlistMovie): static
    {
        if ($this->playlistMovies->removeElement($playlistMovie)) {
            // set the owning side to null (unless already changed)
            if ($playlistMovie->getPlaylistId() === $this) {
                $playlistMovie->setPlaylistId(null);
            }
        }

        return $this;
    }
}
