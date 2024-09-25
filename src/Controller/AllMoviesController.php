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

    #[Route('/all/movies/{page?1}/{include_adult?false}/{sort_by?popularity.desc}', name: 'all_movies')]
    public function index(string $sort_by, int $page, bool $include_adult, Request $request): Response
    {
        $tmdbApiKey = $this->params->get('tmdb_api_key');

        // Récupération du paramètre page à partir de la query string ou de l'URL
        $page = $request->query->getInt('page', $page);
        $includeAdult = $request->query->getBoolean('include_adult', $include_adult);
        $sortBy = $request->query->get('sort_by', $sort_by);
        $voteAverageGte = $request->query->get('vote_average_gte', 0);
        $voteCountGte = $request->query->get('vote_count_gte', 0);
        $withRuntimeGte = $request->query->get('with_runtime_gte', 0);
        // $withGenres = $request->query->get('with_genres', null);

        // Appel API TMDB pour récupérer les films de la page spécifiée
        $responseAllMovies = $this->httpClient->request('GET', "https://api.themoviedb.org/3/discover/movie", [
            'query' => [
                'api_key' => $tmdbApiKey,
                'sort_by' => $sortBy,
                'page' => $page,
                'include_adult' => $includeAdult,
                'vote_average.gte' => $voteAverageGte,
                'vote_count.gte' => $voteCountGte,
                'with_runtime.gte' => $withRuntimeGte,
                // 'with_genres' => $withGenres,
            ]
        ]);

        // dd($responseAllMovies);
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
