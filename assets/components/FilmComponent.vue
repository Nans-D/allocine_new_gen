<template>
  <div style="background-color: #3b1219">
    <div class="container py-5">
      <div v-if="film" class="row">
        <div class="col-auto">
          <img
            :src="`https://image.tmdb.org/t/p/w500${film.poster_path}`"
            alt="Poster du film"
            width="300vw"
            class="rounded"
            style="box-shadow: 1px 1px 10px #000000"
          />
        </div>
        <div class="col-8">
          <div class="row">
            <h1 class="text-light col-12 mb-0">
              {{ film.original_title }} ({{ yearMovie }})
            </h1>
            <div class="text-light fst-italic mb-3" style="font-size: 14px">
              {{ arrayGenre.join(", ") }}
            </div>
            <div class="col-12 ps-4 mb-4">
              <div class="row gap-2">
                <button class="btn btn-light rounded-circle col-auto">
                  <i class="fa-solid fa-heart"></i>
                </button>
                <button class="btn btn-light rounded-circle col-auto">
                  <i class="fa-solid fa-bookmark"></i>
                </button>
              </div>
            </div>
            <h5 class="col-12">Synopsis</h5>
            <p class="text-light col-12">{{ film.overview }}</p>
          </div>
        </div>
      </div>
      <div v-else>
        <p class="text-light">Chargement des détails du film...</p>
      </div>
    </div>
  </div>

  <div class="container my-3">
    <div class="row">
      <div class="col-12">
        <h5 class="text-light">Cast</h5>
        <div class="overflow-auto">
          <div class="d-flex gap-2">
            <div v-for="castMember in credits.cast" :key="castMember.id">
              <img
                :src="`https://image.tmdb.org/t/p/w500/${castMember.profile_path}`"
                class="rounded"
                width="200px"
                alt=""
              />
              <div class="text-center pt-2 text-light">
                {{ castMember.name }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";

const film = ref(null);
const credits = ref([]);
let yearMovie = ref(null);
let arrayGenre = ref([]);

onMounted(() => {
  const filmData = document.getElementById("film-app").dataset.film;
  const creditsData = document.getElementById("film-app").dataset.credits;

  if (filmData) {
    film.value = JSON.parse(filmData);
    yearMovie = film.value.release_date.split("-")[0];

    if (film.value.genres.length > 0) {
      arrayGenre = film.value.genres.map((genre) => genre.name);
    }
    if (creditsData) {
      credits.value = JSON.parse(creditsData);
    }
  }
});
</script>
