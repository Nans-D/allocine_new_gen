<template>
  <div class="background-image-container">
    <!-- Superposition rouge avec opacité -->
    <div class="overlay"></div>

    <!-- Image de fond -->
    <div
      class="background-image"
      :style="{
        backgroundImage:
          backdropPath != null
            ? `url(https://image.tmdb.org/t/p/original${backdropPath})`
            : 'none',
        backgroundSize: 'cover',
        backgroundPosition: 'center',
      }"
    >
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
              <div class="d-flex align-items-end gap-2 mb-3">
                <!-- Les divs de couleur et notes -->
                <div
                  :style="{
                    width: '10px',
                    height: '15px',
                    backgroundColor: averageNote >= 10 ? 'grey' : 'red',
                  }"
                  class="rounded"
                ></div>
                <div
                  :style="{
                    width: '10px',
                    height: '20px',
                    backgroundColor: averageNote >= 3 ? 'orange' : 'grey',
                  }"
                  class="rounded"
                ></div>
                <div
                  :style="{
                    width: '10px',
                    height: '25px',
                    backgroundColor: averageNote >= 5 ? 'yellow' : 'grey',
                  }"
                  class="rounded"
                ></div>
                <div
                  :style="{
                    width: '10px',
                    height: '30px',
                    backgroundColor: averageNote >= 7 ? 'lightGreen' : 'grey',
                  }"
                  class="rounded"
                ></div>
                <div
                  :style="{
                    width: '10px',
                    height: '35px',
                    backgroundColor: averageNote >= 10 ? 'green' : 'grey',
                  }"
                  class="rounded"
                ></div>
                <div class="ps-3 text-light">
                  {{ averageNote }} - ({{ film.vote_count }} votes)
                </div>
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
  </div>

  <div class="container my-3">
    <div class="row">
      <div class="col-12">
        <h5 class="text-light">Cast</h5>
        <div class="overflow-auto">
          <div class="d-flex gap-2">
            <div
              class="p-3 rounded"
              style="background-color: #3b1219"
              v-for="castMember in credits.cast"
              :key="castMember.id"
            >
              <img
                :src="
                  castMember.profile_path != null
                    ? `https://image.tmdb.org/t/p/w500/${castMember.profile_path}`
                    : noImage
                "
                class="rounded"
                width="200px"
                style="
                  object-fit: cover;
                  box-shadow: 5px 10px 10px rgba(0, 0, 0, 0.5);
                "
                alt=""
              />
              <div class="text-center pt-2 text-light fw-bold">
                {{ castMember.name }}
              </div>
              <div style="font-size: 12px" class="text-center text-light">
                {{ castMember.character }}
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
import noImage from "/assets/images/no-image.png";

const film = ref(null);
const credits = ref([]);
const averageNote = ref(null);
const backdropPath = ref(null);
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

    if (film.value.vote_average) {
      averageNote.value = Math.round(film.value.vote_average * 100) / 100;
    }

    if (film.value.backdrop_path) {
      backdropPath.value = film.value.backdrop_path;
    }
  }
});
</script>

<style scoped>
.background-image-container {
  position: relative;
}

.background-image {
  position: relative;
  width: 100%;
  height: 100%; /* Ajuste la hauteur selon tes besoins */
  background-size: cover;
  background-position: center;
}

.overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%; /* Assurez-vous qu'elle correspond à la taille de l'image */
  background-color: #3b1219; /* Rouge avec opacité légère */
  opacity: 0.5;
  z-index: 1; /* S'assurer que l'overlay est au-dessus de l'image */
  pointer-events: none; /* Permet de cliquer à travers l'overlay */
}

.container {
  position: relative;
  z-index: 2; /* Pour s'assurer que le contenu est au-dessus de l'overlay */
}
</style>
