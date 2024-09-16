<?php

namespace App\Entity;

use App\Repository\PlaylistMoviesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaylistMoviesRepository::class)]
class PlaylistMovies
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'playlistMovies')]
    private ?MoviePlaylists $playlist_id = null;

    #[ORM\ManyToOne(inversedBy: 'playlistMovies')]
    private ?Movies $movie_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlaylistId(): ?MoviePlaylists
    {
        return $this->playlist_id;
    }

    public function setPlaylistId(?MoviePlaylists $playlist_id): static
    {
        $this->playlist_id = $playlist_id;

        return $this;
    }

    public function getMovieId(): ?Movies
    {
        return $this->movie_id;
    }

    public function setMovieId(?Movies $movie_id): static
    {
        $this->movie_id = $movie_id;

        return $this;
    }
}
