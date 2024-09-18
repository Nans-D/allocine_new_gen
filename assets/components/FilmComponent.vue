<template>
  <div class="container">
    <div v-if="film">
      <h1>{{ film.original_title }}</h1>
      <img
        :src="`https://image.tmdb.org/t/p/w500${film.poster_path}`"
        alt="Poster du film"
      />
      <p>{{ film.overview }}</p>
    </div>
    <div v-else>
      <p>Chargement des détails du film...</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";

const film = ref(null);

onMounted(() => {
  const filmData = document.getElementById("film-app").dataset.film;
  if (filmData) {
    film.value = JSON.parse(filmData);
  }
});
</script>
