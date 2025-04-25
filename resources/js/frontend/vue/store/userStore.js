import { defineStore } from "pinia";
import axios from "axios";

export const useUserStore = defineStore("user", {
    state: () => ({
        user: null,
        isAuthenticated: false,
    }),

    actions: {
        async fetchUser() {
            try {
                const response = await axios.get("/api/user");
                this.user = response.data;
                this.isAuthenticated = true;
            } catch (error) {
                this.user = null;
                this.isAuthenticated = false;
            }
        },

        logout() {
            this.user = null;
            this.isAuthenticated = false;
        },
    },
});
