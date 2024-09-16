<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class HomeController extends AbstractController
{
    private $httpClient;
    private $params;

    public function __construct(HttpClientInterface $httpClient, ParameterBagInterface $params)
    {
        $this->httpClient = $httpClient;
        $this->params = $params;
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        // Récupérer la clé API TMDB via les paramètres Symfony
        $tmdbApiKey = $this->params->get('tmdb_api_key');

        // Faire une requête à l'API TMDB pour obtenir les films populaires
        $response = $this->httpClient->request('GET', 'https://api.themoviedb.org/3/movie/popular', [
            'query' => [
                'api_key' => $tmdbApiKey,
                'language' => 'fr-FR',
                'page' => 1
            ]
        ]);

        // Convertir la réponse JSON en tableau PHP
        $movies = $response->toArray();

        // Rendre la vue Twig avec les films populaires
        return $this->render('base.html.twig', [
            'movies' => $movies['results'], // Passer les films à la vue
        ]);
    }
}
