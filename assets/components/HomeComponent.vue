<template>
  <div class="container">
    <header class="bg-secondary-subtle p-3 row">
      <form class="col-6" action="" @submit.prevent="searchMovies">
        <div class="row">
          <div class="col-8">
            <input
              type="email"
              class="form-control"
              id="exampleFormControlInput1"
              placeholder="Rechercher un film"
            />
          </div>
          <button class="btn btn-primary col-4">Rechercher</button>
        </div>
      </form>
      <div class="col-6">
        <ul class="d-flex list-unstyled gap-3">
          <li>Moods</li>
          <li><a href="{{ path('app_login') }}">Connexion</a></li>
        </ul>
      </div>
    </header>
    <Carousel :items-to-show="1" :autoplay="10000" :loop="true">
      <Slide v-for="(movie, index) in movies" :key="index">
        <img
          :src="`https://image.tmdb.org/t/p/w500/${movie.poster_path}`"
          :alt="movie.original_title"
          class="d-block w-100"
        />
        <div class="carousel-caption d-none d-md-block">
          <h5>{{ movie.original_title }}</h5>
        </div>
      </Slide>
    </Carousel>
    <h1>Films Populaires</h1>
    <div class="overflow-auto">
      <ul class="list-unstyled d-flex">
        <li v-for="movie in movies" :key="movie.id" class="w-25 m-3">
          <img
            :src="`https://image.tmdb.org/t/p/w500/${movie.poster_path}`"
            class="rounded"
            width="200px"
            alt=""
          />
          <div class="text-center pt-2">
            {{ movie.original_title }}
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { Carousel, Slide } from "vue3-carousel";
import "vue3-carousel/dist/carousel.css";

const movies = ref([]);
const searchQuery = ref("");

onMounted(() => {
  const moviesData = document.getElementById("home-app").dataset.movies;
  if (moviesData) {
    movies.value = JSON.parse(moviesData);
  }
});

const searchMovies = () => {
  // Votre logique de recherche ici
};
</script>
