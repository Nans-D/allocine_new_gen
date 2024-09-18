<template>
  <div class="container">
    <header class="bg-secondary-subtle p-3 row">
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
          <button class="btn btn-primary col-4">Rechercher</button>
        </div>
      </form>
      <div class="col-6">
        <ul class="d-flex list-unstyled gap-3">
          <li>Moods</li>
          <li><a :href="loginUrl">Connexion</a></li>
        </ul>
      </div>
    </header>
    <Carousel :items-to-show="1" :autoplay="10000" :loop="true">
      <Slide v-for="(movie, index) in movies" :key="index">
        <img
          :src="`https://image.tmdb.org/t/p/w500${movie.backdrop_path}`"
          :alt="movie.original_title"
          class="d-block w-100"
        />
        <div class="carousel-caption d-none d-md-block">
          <h5 class="text-light">{{ movie.original_title }}</h5>
        </div>
      </Slide>
    </Carousel>
    <section>
      <h2>Films Populaires</h2>
      <div class="overflow-auto">
        <ul class="list-unstyled d-flex">
          <li
            v-for="movie in movies"
            :key="movie.id"
            class="w-25 m-3"
            @click="goToFilm(movie.id)"
            style="cursor: pointer"
          >
            <img
              :src="`https://image.tmdb.org/t/p/w500${movie.poster_path}`"
              class="rounded"
              width="200px"
              alt=""
            />
            <div class="text-center pt-2 text-light">
              {{ movie.original_title }}
            </div>
          </li>
        </ul>
      </div>
    </section>
    <section>
      <h2>Films à l'affiche</h2>
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
  }
  if (nowPlayingMoviesData) {
    nowPlayingMovies.value = JSON.parse(nowPlayingMoviesData);
  }
});

const goToFilm = (movieId) => {
  window.location.href = `/film/${movieId}`; // Redirige vers la route Symfony
};

const searchMovies = () => {
  // Votre logique de recherche ici
};
</script>
