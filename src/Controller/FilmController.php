<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route; // Assurez-vous d'utiliser le bon namespace
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class FilmController extends AbstractController
{
    private HttpClientInterface $httpClient;
    private ParameterBagInterface $params;

    public function __construct(HttpClientInterface $httpClient, ParameterBagInterface $params)
    {
        $this->httpClient = $httpClient;
        $this->params = $params;
    }

    #[Route('/film/{id}', name: 'app_film')]
    public function index(int $id): Response
    {
        $tmdbApiKey = $this->params->get('tmdb_api_key');

        $response = $this->httpClient->request('GET', "https://api.themoviedb.org/3/movie/{$id}", [
            'query' => [
                'api_key' => $tmdbApiKey,
                'language' => 'fr-FR',
            ]
        ]);

        $creditResponse = $this->httpClient->request('GET', "https://api.themoviedb.org/3/movie/{$id}/credits", [
            'query' => [
                'api_key' => $tmdbApiKey,
                'language' => 'fr-FR',
            ]
        ]);

        if ($response->getStatusCode() !== 200) {
            throw $this->createNotFoundException('Film non trouvé');
        }

        if ($creditResponse->getStatusCode() !== 200) {
            throw $this->createNotFoundException('credits non trouvé');
        }

        $film = $response->toArray();
        $credits = $creditResponse->toArray();

        // dd($film);

        return $this->render('film/index.html.twig', [
            'film' => $film,
            'credits' => $credits,

        ]);
    }
}
