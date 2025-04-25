import { defineStore } from "pinia";
import api from "../axios";

export const useAuthStore = defineStore("auth", {
    state: () => ({
        customer: null,
        token: localStorage.getItem("token") || null,
        isAuthenticated: false,
    }),

    actions: {
        async login(email, password, type) {
            try {
                const { data } = await api.post("/login", {
                    email,
                    password,
                    type,
                });
                this.token = data.token;
                this.customer = data.customer;
                this.isAuthenticated = true;
                localStorage.setItem("token", data.token);
                return true;
            } catch (error) {
                console.error("Login failed:", error);
                return false;
            }
        },

        async fetchCustomer() {
            try {
                const { data } = await api.get("/user");
                this.customer = data;
                this.isAuthenticated = true;
            } catch (error) {
                this.logout();
            }
        },

        logout() {
            localStorage.removeItem("token");
            this.token = null;
            this.customer = null;
            this.isAuthenticated = false;
        },
    },
});
