<template>
    <Breadcrumb :title="'Login'" :breadcrumbs="breadcrumbItems" />
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form @submit.prevent="handleLogin">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input
                                    v-model="email"
                                    type="email"
                                    class="form-control"
                                    required
                                />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input
                                    v-model="password"
                                    type="password"
                                    class="form-control"
                                    required
                                />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">User Type</label>
                                <select v-model="type" class="form-control">
                                    <option value="website">
                                        Website User
                                    </option>
                                    <option value="mobile">Mobile User</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                Login
                            </button>
                        </form>
                    </div>
                </div>
                <p v-if="errorMessage" class="text-danger mt-2">
                    {{ errorMessage }}
                </p>
                <button @click="clickEvent">click event</button>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from "vue";
import { useAuthStore } from "../../store/authStore";
import { useRouter } from "vue-router";
import Breadcrumb from "../layouts/Breadcrumb.vue";
import { useNotification } from "@kyvg/vue3-notification";
export default {
    components: {
        Breadcrumb,
    },
    data() {
        return {
            breadcrumbItems: [
                { label: "Home", link: "/" },
                { label: "Login", link: "/customerlogin" },
            ],
        };
    },
    setup() {
        const { notify } = useNotification();
        const email = ref("");
        const password = ref("");
        const type = ref("website");
        const errorMessage = ref("");
        const authStore = useAuthStore();
        const router = useRouter();

        const handleLogin = async () => {
            const success = await authStore.login(
                email.value,
                password.value,
                type.value
            );
            if (success) {
                router.push("/");
            } else {
                errorMessage.value = "Invalid login credentials!";
            }
        };

        const clickEvent = () => {
            notify({
                title: "This is the <em>title</em>",
                text: "This is some <b>content</b>",
                type: "warn",
            });
        };

        return { email, password, type, handleLogin, errorMessage, clickEvent };
    },
};
</script>
