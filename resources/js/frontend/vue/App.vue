<template>
    <div>
        <Header />
        <router-view></router-view>
        <Footer />
        <notifications />
    </div>
</template>

<script>
import { onMounted } from "vue";
import { useAuthStore } from "./store/authStore";
import Header from "./components/layouts/Header.vue";
import Footer from "./components/layouts/Footer.vue";

export default {
    components: { Header, Footer },
    setup() {
        const userStore = useAuthStore();

        // Fetch user when app loads
        onMounted(() => {
            userStore.fetchCustomer();
        });

        return {};
    },
};
</script>
