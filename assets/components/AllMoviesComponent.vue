<template>
  <div class="container my-5">
    <div class="row">
      <div class="col-2 text-light">
        <div class="card">Trier</div>
      </div>
      <div class="col-10">
        <div class="row">
          <!-- Affichage des films -->
          <div
            v-for="film in films"
            :key="film.id"
            class="col-3 p-3 d-flex flex-column justify-content-center align-items-center"
            @click="goToFilm(film.id)"
          >
            <div>
              <img
                :src="`https://image.tmdb.org/t/p/w500${film.poster_path}`"
                class="rounded"
                width="200px"
                alt="Poster du film"
              />
            </div>
            <div class="text-light pt-3">
              {{ film.original_title }}
            </div>
          </div>
        </div>

        <!-- Pagination Links -->
        <nav v-if="pagesCount > 1" class="mt-4">
          <ul class="pagination justify-content-center">
            <!-- Pages 1, 2, 3 -->
            <li v-for="page in displayedPages" :key="page" class="page-item">
              <a
                href="#"
                class="page-link"
                @click.prevent="fetchPage(page)"
                :class="{ active: page === currentPage }"
              >
                {{ page }}
              </a>
            </li>

            <!-- Input pour numéro de page personnalisé -->
            <li class="page-item">
              <input
                type="number"
                v-model="customPage"
                class="form-control"
                min="1"
                :max="pagesCount"
                style="width: 70px"
              />
            </li>
            <li class="page-item">
              <a
                href="#"
                class="page-link"
                @click.prevent="fetchPage(customPage)"
              >
                Aller
              </a>
            </li>

            <!-- Dernière page -->
            <li class="page-item">
              <a
                href="#"
                class="page-link"
                @click.prevent="fetchPage(pagesCount)"
                :class="{ active: currentPage === pagesCount }"
              >
                Dernière ({{ pagesCount }})
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";

// Références réactives pour les films, le nombre total de pages, la page actuelle, et la page personnalisée
const films = ref([]);
const pagesCount = ref(0);
const currentPage = ref(1);
const customPage = ref(1);

// Calculer les pages à afficher (1, 2, 3)
const displayedPages = computed(() => {
  return Array.from(
    { length: Math.min(3, pagesCount.value) },
    (_, index) => index + 1
  );
});

onMounted(() => {
  // Récupérer les données depuis le dataset de l'élément contenant
  const allMovies = document.getElementById("all-movies-app").dataset.movies;
  const totalPages =
    document.getElementById("all-movies-app").dataset.totalPages;
  const current = document.getElementById("all-movies-app").dataset.currentPage;

  // Parsing des données JSON
  if (allMovies) {
    films.value = JSON.parse(allMovies);
  }

  if (totalPages) {
    pagesCount.value = parseInt(totalPages, 10); // Nombre total de pages
  }

  if (current) {
    currentPage.value = parseInt(current, 10); // Page actuelle
    customPage.value = currentPage.value; // Synchronisation initiale
  }
});

// Redirection vers la page d'un film spécifique
const goToFilm = (movieId) => {
  window.location.href = `/film/${movieId}`; // Redirection vers la route Symfony
};

// Fonction pour charger une autre page de films
const fetchPage = (page) => {
  if (page >= 1 && page <= pagesCount.value) {
    window.location.href = `/all/movies/${page}`;
  }
};
</script>
