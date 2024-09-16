<template>
  <div>
    <h1>Films Populaires</h1>
    <ul>
      <li v-for="movie in movies" :key="movie.id">{{ movie.original_title }}</li>
    </ul>
  </div>
</template>
  
<script setup>
import { ref, onMounted } from 'vue';

const movies = ref([]); // Déclarer la variable réactive movies

onMounted(() => {
  // Récupérer les données des films à partir de l'attribut data-movies
  const moviesData = document.getElementById('app').dataset.movies;
  if (moviesData) {
    movies.value = JSON.parse(moviesData);  // Assigner les données à movies
  }
});
</script>
  