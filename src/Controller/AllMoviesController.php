<?php

namespace App\Controller;

// use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route; // Assurez-vous d'utiliser le bon namespace
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;

class AllMoviesController extends AbstractController
{
    private HttpClientInterface $httpClient;
    private ParameterBagInterface $params;

    public function __construct(HttpClientInterface $httpClient, ParameterBagInterface $params)
    {
        $this->httpClient = $httpClient;
        $this->params = $params;
    }

    #[Route('/all/movies/{page?1}', name: 'app_all_movies')]
    public function index(int $page, Request $request): Response
    {
        $tmdbApiKey = $this->params->get('tmdb_api_key');

        // Récupération du paramètre page à partir de la query string ou de l'URL
        $page = $request->query->getInt('page', $page);

        // Appel API TMDB pour récupérer les films de la page spécifiée
        $responseAllMovies = $this->httpClient->request('GET', "https://api.themoviedb.org/3/discover/movie", [
            'query' => [
                'api_key' => $tmdbApiKey,
                'sort_by' => 'popularity.desc',
                'page' => $page, // Utilisation de la page actuelle
            ]
        ]);

        // Vérification du code de retour de l'API
        if ($responseAllMovies->getStatusCode() !== 200) {
            throw $this->createNotFoundException('Films non trouvés');
        }

        // Récupérer les résultats sous forme de tableau
        $allMovies = $responseAllMovies->toArray();

        // Envoyer les résultats à la vue Twig
        return $this->render('all_movies/index.html.twig', [
            'movies' => $allMovies['results'],  // Les films pour la page actuelle
            'total_pages' => $allMovies['total_pages'],  // Le nombre total de pages
            'current_page' => $page,  // La page actuelle
        ]);
    }
}
