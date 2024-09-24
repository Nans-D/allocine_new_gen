<template>
  <div id="sideBar" class="col-12 col-xl-3 col-xxl-2 py-3 text-light">
    <div class="card">
      <div
        class="card-header d-flex justify-content-between align-items-center"
      >
        <div class="fw-bold">Trier</div>
      </div>

      <div>
        <select @change="filterMovies" v-model="select" class="form-select">
          <option v-for="option in options" :value="option.value">
            {{ option.text }}
          </option>
        </select>
      </div>
    </div>
    <div class="card mt-2">
      <div
        @click="eventOpen"
        class="card-header d-flex justify-content-between align-items-center"
      >
        <div class="fw-bold">Filtrer</div>
        <i class="fa-solid fa-chevron-down"></i>
      </div>
      <form v-show="open" class="p-3">
        <div>
          <div class="pb-2">Afficher</div>
          <ul class="list-unstyled ps-3">
            <li>
              <input type="radio" id="all" v-model="checkedFilters" value="1" />
              <label class="ps-2" for="all">Tous</label>
            </li>
            <li>
              <input
                type="radio"
                id="neverSeen"
                v-model="checkedFilters"
                value="2"
              />
              <label class="ps-2" for="neverSeen">Jamais vus</label>
            </li>
            <li>
              <input
                type="radio"
                id="alreadySeen"
                v-model="checkedFilters"
                value="3"
              />
              <label class="ps-2" for="alreadySeen">Déjà vus</label>
            </li>
          </ul>
        </div>
        <hr />
        <div>
          <div class="pb-2">Genres</div>
          <ul class="list-unstyled row">
            <li class="col-auto" v-for="genre in genres" :key="genre">
              <input
                type="button"
                class="btn mb-2 btn-outline-danger py-1"
                :value="genre"
                style="
                  background-color: #e5484d !important;
                  color: white;
                  font-size: 10px;
                "
              />
            </li>
          </ul>
        </div>
        <hr />
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
            />
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Filtrer</button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";

// Data pour les options et les genres
const select = ref(null);
let open = ref(false);

const eventOpen = () => {
  open.value = !open.value;
};

const options = ref([
  { text: "Popularité +/-", value: "?sort_by=popularity.desc" },
  { text: "Popularité -/+", value: "?sort_by=popularity.asc" },
  { text: "Evaluations +/-", value: "?sort_by=vote_average.desc" },
  { text: "Evaluations -/+", value: "?sort_by=vote_average.asc" },
  { text: "Date de sortie +/-", value: "?sort_by=primary_release_date.asc" },
  { text: "Date de sortie -/+", value: "?sort_by=primary_release_date.desc" },
  { text: "Titre A/Z", value: "?sort_by=original_title.asc" },
  { text: "Titre Z/A", value: "?sort_by=original_title.desc" },
]);

const genres = ref([
  "Action",
  "Comédie",
  "Drame",
  "Fantastique",
  "Science-Fiction",
  "Thriller",
]);

const checkedFilters = ref([]);

// Fonction de filtrage des films
const filterMovies = () => {
  window.location.href = `/all/movies/1/${select.value}`;
};
</script>
