<template>
  <form
    @submit.prevent="submitForm"
    id="sideBar"
    class="col-12 col-xl-3 col-xxl-2 py-3 text-light"
  >
    <div class="card">
      <div
        @click="eventOpenTri"
        class="card-header d-flex justify-content-between align-items-center"
      >
        <div class="fw-bold">Trier</div>
        <i class="fa-solid fa-chevron-down"></i>
      </div>

      <div v-show="openTri">
        <select v-model="selected" class="form-select">
          <option disabled value="">Sélectionner</option>
          <option v-for="option in options" :value="option.value">
            {{ option.text }}
          </option>
        </select>
      </div>
    </div>
    <div class="card mt-2">
      <div
        @click="eventOpenFilter"
        class="card-header d-flex justify-content-between align-items-center"
      >
        <div class="fw-bold">Filtrer</div>
        <i class="fa-solid fa-chevron-down"></i>
      </div>
      <div v-show="openFilter" class="p-3">
        <div>
          <div class="pb-2">Afficher</div>
          <ul class="list-unstyled ps-3">
            <li>
              <input type="radio" id="all" v-model="checkedRadio" value="all" />
              <label class="ps-2" for="all">Tous</label>
            </li>
            <li>
              <input
                type="radio"
                id="neverSeen"
                v-model="checkedRadio"
                value="neverSeen"
              />
              <label class="ps-2" for="neverSeen">Jamais vus</label>
            </li>
            <li>
              <input
                type="radio"
                id="alreadySeen"
                v-model="checkedRadio"
                value="alreadySeen"
              />
              <label class="ps-2" for="alreadySeen">Déjà vus</label>
            </li>
          </ul>
        </div>
        <hr />
        <!-- <div>
          <div class="pb-2">Genres</div>
          <ul class="list-unstyled row">
            <li
              @click="genrePush(genre)"
              class="col-auto"
              v-for="genre in genres"
              :key="genre"
            >
              <input
                type="button"
                :class="[
                  'btn',
                  'mb-2',
                  'py-1',
                  genreObject[genre]
                    ? 'btn-outline-primary'
                    : 'btn-outline-danger',
                ]"
                :value="genre"
                style="font-size: 10px"
              />
            </li>
          </ul>
        </div>
        <hr /> -->
        <div>
          <div>Notes</div>
          <div>
            <input
              type="range"
              class="form-range"
              min="0"
              max="10"
              step="1"
              id="customRange3"
              v-model="note"
            />
          </div>
          <div class="px-1 d-flex justify-content-between align-items-center">
            <div style="font-size: 10px">0</div>
            <div style="font-size: 10px">5</div>
            <div style="font-size: 10px">10</div>
          </div>
        </div>
        <hr />
        <div>
          <div>Nombre de votes minimum</div>
          <div>
            <input
              type="range"
              class="form-range"
              min="0"
              max="500"
              step="50"
              id="customRange3"
              v-model="vote"
            />
          </div>
        </div>
        <hr />
        <div>
          <div>Durée (en minutes)</div>
          <div>
            <input
              type="range"
              class="form-range"
              min="0"
              max="360"
              step="15"
              id="customRange3"
              v-model="duration"
            />
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Filtrer</button>
      </div>
    </div>
  </form>
</template>

<script setup>
import { ref } from "vue";

// Data pour les options et les genres
const selected = ref("");
let openTri = ref(false);
let openFilter = ref(true);
let checkedRadio = ref("all");
let note = ref("");
let vote = ref("");
let duration = ref("");
// let genreObject = ref({});

const eventOpenFilter = () => {
  openFilter.value = !openFilter.value;
};
const eventOpenTri = () => {
  openTri.value = !openTri.value;
};

const options = ref([
  { text: "Popularité +/-", value: "popularity.desc" },
  { text: "Popularité -/+", value: "popularity.asc" },
  { text: "Evaluations +/-", value: "vote_average.desc" },
  { text: "Evaluations -/+", value: "vote_average.asc" },
  { text: "Date de sortie +/-", value: "primary_release_date.asc" },
  { text: "Date de sortie -/+", value: "primary_release_date.desc" },
  { text: "Titre A/Z", value: "original_title.asc" },
  { text: "Titre Z/A", value: "original_title.desc" },
]);

// const genres = ref([
//   "Action",
//   "Comédie",
//   "Drame",
//   "Fantastique",
//   "Science-Fiction",
//   "Thriller",
// ]);

// const genrePush = (selectedGenre) => {
//   // Si le genre est déjà sélectionné, on le désélectionne
//   if (genreObject.value[selectedGenre]) {
//     delete genreObject.value[selectedGenre];
//   } else {
//     // Sinon, on le sélectionne
//     genreObject.value[selectedGenre] = true;
//   }
//   console.log(genreObject.value);
// };

const submitForm = (e) => {
  e.preventDefault();

  //   const selectedGenres = Object.keys(genreObject.value).filter(
  //     (key) => genreObject.value[key]
  //   );

  //   const genreParam = selectedGenres ? `&with_genres=${selectedGenres}` : "";
  selected.value !== ""
    ? (selected.value = selected.value)
    : (selected.value = "popularity.desc");
  console.log(selected.value);
  vote.value !== "" ? (vote.value = "&vote_count.gte=" + vote.value) : "";
  note.value !== "" ? (note.value = "&vote_average.gte=" + note.value) : "";
  duration.value !== ""
    ? (duration.value = "&with_runtime.gte=" + duration.value)
    : "";

  window.location.href = `/all/movies/1/false?sort_by=${selected.value}${vote.value}${note.value}${duration.value}`;
};

// Fonction de filtrage des films
const filterMovies = () => {
  //   console.log(selected.value);
  window.location.href = `/all/movies/1/false/${selected.value}`;
};
</script>
