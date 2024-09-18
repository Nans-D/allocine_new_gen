import "./styles/app.css";

import { createApp } from "vue";
import HomeComponent from "./components/HomeComponent.vue";
import FilmComponent from "./components/FilmComponent.vue";

const homeApp = document.getElementById("home-app");
if (homeApp) {
  createApp(HomeComponent).mount("#home-app");
}

const filmApp = document.getElementById("film-app");
if (filmApp) {
  createApp(FilmComponent).mount("#film-app");
}
