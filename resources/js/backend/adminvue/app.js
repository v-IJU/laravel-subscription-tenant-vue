import { createApp } from "vue";
import { createPinia } from "pinia";
import router from "./router";
import Notifications from "@kyvg/vue3-notification";
import ExampleComponent from "./components/dashboard/ExampleComponent.vue";

const app = createApp();
app.component("example-component", ExampleComponent);
app.mount("#admin-app");
