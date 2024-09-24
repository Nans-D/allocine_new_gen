<template>
  <div style="background-color: #3b1219; color: white">
    <div class="container">
      <header class="py-3 row">
        <form class="col-6" @submit.prevent="searchMovies">
          <div class="row">
            <div class="col-8">
              <input
                type="text"
                class="form-control"
                placeholder="Rechercher un film"
                v-model="searchQuery"
              />
            </div>
            <button class="btn col-auto" style="background-color: #e5484d">
              Rechercher
            </button>
          </div>
        </form>
        <div class="col-6 d-flex justify-content-end align-items-center">
          <ul class="d-flex list-unstyled gap-3 m-0">
            <li>
              <a
                href="#"
                class="link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                >Séries</a
              >
            </li>
            <li @click="goToAllMovies()">
              <a
                href="#"
                class="link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                >Films</a
              >
            </li>
            <li>
              <a
                href="#"
                class="link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                >Moods</a
              >
            </li>
            <li>
              <a :href="loginUrl" style="cursor: pointer">Se connecter</a>
            </li>
          </ul>
        </div>
      </header>
    </div>
  </div>

  <Carousel :items-to-show="1" :autoplay="10000" :loop="true">
    <Slide v-for="(movie, index) in movies" :key="index">
      <img
        :src="`https://image.tmdb.org/t/p/original${movie.backdrop_path}`"
        :alt="movie.original_title"
        class="d-block w-100"
      />
      <div class="carousel-caption d-none d-md-block">
        <!-- <h5 class="text-light">{{ movie.original_title }}</h5> -->
      </div>
    </Slide>
  </Carousel>
  <section class="container">
    <h2 class="text-light">Films Populaires</h2>
    <div class="overflow-auto">
      <ul class="list-unstyled d-flex">
        <li
          v-for="movie in movies"
          :key="movie.id"
          class="w-25 m-3 position-relative"
          @click="goToFilm(movie.id)"
          style="cursor: pointer"
        >
          <img
            :src="`https://image.tmdb.org/t/p/w500${movie.poster_path}`"
            class="rounded"
            width="200px"
            alt=""
          />
          <div class="text-center pt-2 text-light pt-4">
            {{ movie.original_title }}
          </div>
          <div
            class="position-absolute start-0 rounded-circle text-center d-flex justify-content-center align-items-center"
            style="
              background-color: red;
              width: 50px;
              height: 50px;
              bottom: 60px;
            "
          >
            {{ newNotes[movie.id] }}
          </div>
        </li>
      </ul>
    </div>
  </section>
  <div style="background-color: #3b1219">
    <section class="container pt-3">
      <h2 class="text-light">Films à l'affiche</h2>
      <div class="overflow-auto">
        <ul class="list-unstyled d-flex">
          <li
            v-for="nowPlayingMovie in nowPlayingMovies"
            :key="nowPlayingMovie.id"
            class="w-25 m-3"
            @click="goToFilm(nowPlayingMovie.id)"
            style="cursor: pointer"
          >
            <img
              :src="`https://image.tmdb.org/t/p/w500${nowPlayingMovie.poster_path}`"
              class="rounded"
              width="200px"
              alt=""
            />
            <div class="text-center pt-2 text-light">
              {{ nowPlayingMovie.original_title }}
            </div>
          </li>
        </ul>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { Carousel, Slide } from "vue3-carousel";
import "vue3-carousel/dist/carousel.css";

const movies = ref([]);
let movieAverage = ref([]);
let newNotes = ref([]);
const nowPlayingMovies = ref([]);
const searchQuery = ref("");
const loginUrl = ref("");

onMounted(() => {
  const homeAppElement = document.getElementById("home-app");
  const popularMoviesData = homeAppElement.dataset.popularMovies;
  const nowPlayingMoviesData = homeAppElement.dataset.nowPlayingMovies;
  loginUrl.value = homeAppElement.dataset.loginUrl;

  if (popularMoviesData) {
    movies.value = JSON.parse(popularMoviesData);

    // Créer un objet pour stocker les notes avec l'ID comme clé
    movieAverage = movies.value.reduce((acc, movie) => {
      acc[movie.id] = Math.round(movie.vote_average * 100) / 100; // Associer l'ID à la note arrondie
      return acc;
    }, {});

    // Si newNotes est un objet, copier les valeurs dans newNotes.value
    newNotes.value = { ...newNotes.value, ...movieAverage };
    console.log(newNotes.value);
  }

  if (nowPlayingMoviesData) {
    nowPlayingMovies.value = JSON.parse(nowPlayingMoviesData);
  }
});

const goToFilm = (movieId) => {
  window.location.href = `/film/${movieId}`; // Redirige vers la route Symfony
};

const goToAllMovies = () => {
  window.location.href = `/all/movies`; // Redirige vers la route Symfony
};

const searchMovies = () => {
  // Votre logique de recherche ici
};
</script>
