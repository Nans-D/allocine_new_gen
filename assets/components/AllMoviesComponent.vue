<template>
  <div class="container my-5">
    <div class="row">
      <Sidebar />
      <div class="col-12 col-xl-9 col-xxl-10">
        <div class="row">
          <!-- Affichage des films -->
          <div
            v-for="film in films"
            :key="film.id"
            class="col-6 col-lg-4 col-xxl-3 p-3 d-flex flex-column align-items-center"
            style="cursor: pointer; height: 450px"
            @click="goToFilm(film.id)"
          >
            <div
              class="row p-2 rounded"
              style="
                width: 100%;
                height: 100%;
                background-color: #3b1219;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
              "
            >
              <div class="col-12 p-0" style="width: 100%; height: 80%">
                <img
                  :src="
                    film.poster_path != null
                      ? `https://image.tmdb.org/t/p/w500${film.poster_path}`
                      : noImage
                  "
                  width="100%"
                  height="100%"
                  alt="Poster du film"
                  style="object-fit: contain"
                />
              </div>
              <div class="col-12 text-light text-center text-wrap pt-2">
                {{ film.original_title }}
              </div>
            </div>
          </div>
        </div>

        <!-- Pagination Links -->
        <nav v-if="pagesCount > 1" class="mt-4">
          <ul class="pagination justify-content-center">
            <!-- Pages 1, 2, 3 -->
            <li v-for="page in displayedPages" :key="page" class="page-item">
              <a
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
                <i class="fa-solid fa-arrow-right"></i>
              </a>
            </li>

            <!-- Dernière page -->
            <li class="page-item">
              <a
                href="#"
                class="page-link"
                @click.prevent="fetchPage(20)"
                :class="{ active: currentPage === 20 }"
              >
                20
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
import noImage from "/assets/images/no-image.png";
import Sidebar from "./Sidebar.vue";
// Références réactives pour les films, le nombre total de pages, la page actuelle, et la page personnalisée
const films = ref([]);
const pagesCount = ref(0);
const currentPage = ref(1);
const customPage = ref(1);

// side bar

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

    for (let i = 0; i < films.value.length; i++) {
      if (films.value[i].original_title.length > 30) {
        films.value[i].original_title =
          films.value[i].original_title.substring(0, 30) + "...";
      }
    }
    if (totalPages) {
      pagesCount.value = parseInt(totalPages, 10); // Nombre total de pages
    }

    if (current) {
      currentPage.value = parseInt(current, 10); // Page actuelle
      customPage.value = currentPage.value; // Synchronisation initiale
    }
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
