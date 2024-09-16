<?php

namespace App\Entity;

use App\Repository\MoviesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MoviesRepository::class)]
class Movies
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $tmdb_id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $release_date = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $overview = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $poster_path = null;

    #[ORM\Column(nullable: true)]
    private ?float $rating_average = null;

    #[ORM\Column(nullable: true)]
    private ?int $rating_count = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    /**
     * @var Collection<int, Reviews>
     */
    #[ORM\OneToMany(targetEntity: Reviews::class, mappedBy: 'movie_id')]
    private Collection $reviews;

    /**
     * @var Collection<int, PlaylistMovies>
     */
    #[ORM\OneToMany(targetEntity: PlaylistMovies::class, mappedBy: 'movie_id')]
    private Collection $playlistMovies;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
        $this->playlistMovies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTmdbId(): ?int
    {
        return $this->tmdb_id;
    }

    public function setTmdbId(int $tmdb_id): static
    {
        $this->tmdb_id = $tmdb_id;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->release_date;
    }

    public function setReleaseDate(\DateTimeInterface $release_date): static
    {
        $this->release_date = $release_date;

        return $this;
    }

    public function getOverview(): ?string
    {
        return $this->overview;
    }

    public function setOverview(?string $overview): static
    {
        $this->overview = $overview;

        return $this;
    }

    public function getPosterPath(): ?string
    {
        return $this->poster_path;
    }

    public function setPosterPath(?string $poster_path): static
    {
        $this->poster_path = $poster_path;

        return $this;
    }

    public function getRatingAverage(): ?float
    {
        return $this->rating_average;
    }

    public function setRatingAverage(?float $rating_average): static
    {
        $this->rating_average = $rating_average;

        return $this;
    }

    public function getRatingCount(): ?int
    {
        return $this->rating_count;
    }

    public function setRatingCount(?int $rating_count): static
    {
        $this->rating_count = $rating_count;

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
            $review->setMovieId($this);
        }

        return $this;
    }

    public function removeReview(Reviews $review): static
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getMovieId() === $this) {
                $review->setMovieId(null);
            }
        }

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
            $playlistMovie->setMovieId($this);
        }

        return $this;
    }

    public function removePlaylistMovie(PlaylistMovies $playlistMovie): static
    {
        if ($this->playlistMovies->removeElement($playlistMovie)) {
            // set the owning side to null (unless already changed)
            if ($playlistMovie->getMovieId() === $this) {
                $playlistMovie->setMovieId(null);
            }
        }

        return $this;
    }
}
