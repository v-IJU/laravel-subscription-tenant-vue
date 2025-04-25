<template>
    <!-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <router-link class="navbar-brand" to="/">MyVueSite</router-link>

            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
                aria-controls="navbarNav"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <router-link class="nav-link" to="/">Home</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/about"
                            >About</router-link
                        >
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/contact"
                            >Contact</router-link
                        >
                    </li>

                    <li v-if="isAuthenticated" class="nav-item dropdown">
                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown"
                        >
                            {{ customer?.name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <router-link class="dropdown-item" to="/profile"
                                    >Profile</router-link
                                >
                            </li>
                            <li>
                                <button class="dropdown-item" @click="logout">
                                    Logout
                                </button>
                            </li>
                        </ul>
                    </li>

                    <li v-else class="nav-item">
                        <router-link class="nav-link" to="/customerlogin"
                            >Login</router-link
                        >
                    </li>
                </ul>
            </div>
        </div>
    </nav> -->
    <!-- navigation -->
    <header class="navigation bg-tertiary">
        <nav class="navbar navbar-expand-xl navbar-light text-center py-3">
            <div class="container">
                <a class="navbar-brand" href="index.html">
                    <img
                        loading="prelaod"
                        decoding="async"
                        class="img-fluid"
                        width="160"
                        src="vueimages/logo.png"
                        alt="Wallet"
                    />
                </a>
                <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div
                    class="collapse navbar-collapse"
                    id="navbarSupportedContent"
                >
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <router-link class="nav-link" to="/"
                                >Home</router-link
                            >
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" to="/about"
                                >About</router-link
                            >
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="how-it-works.html"
                                >How It Works</a
                            >
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="services.html"
                                >Services</a
                            >
                        </li> -->
                        <li class="nav-item">
                            <router-link class="nav-link" to="/contact"
                                >Contact</router-link
                            >
                        </li>
                        <!-- <li class="nav-item dropdown">
                            <a
                                class="nav-link dropdown-toggle"
                                href="#"
                                id="navbarDropdown"
                                role="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                                >Pages</a
                            >
                            <ul
                                class="dropdown-menu"
                                aria-labelledby="navbarDropdown"
                            >
                                <li>
                                    <a class="dropdown-item" href="blog.html"
                                        >Blog</a
                                    >
                                </li>
                                <li>
                                    <a
                                        class="dropdown-item"
                                        href="blog-details.html"
                                        >Blog Details</a
                                    >
                                </li>
                                <li>
                                    <a
                                        class="dropdown-item"
                                        href="service-details.html"
                                        >Service Details</a
                                    >
                                </li>
                                <li>
                                    <a class="dropdown-item" href="faq.html"
                                        >FAQ&#39;s</a
                                    >
                                </li>
                                <li>
                                    <a class="dropdown-item" href="legal.html"
                                        >Legal</a
                                    >
                                </li>
                                <li>
                                    <a class="dropdown-item" href="terms.html"
                                        >Terms &amp; Condition</a
                                    >
                                </li>
                                <li>
                                    <a
                                        class="dropdown-item"
                                        href="privacy-policy.html"
                                        >Privacy &amp; Policy</a
                                    >
                                </li>
                            </ul>
                        </li> -->
                    </ul>

                    <div v-if="isAuthenticated">
                        <div
                            class="collapse navbar-collapse"
                            id="navbarNavDarkDropdown"
                        >
                            <ul class="navbar-nav">
                                <li class="nav-item dropdown">
                                    <a
                                        class="nav-link dropdown-toggle"
                                        href="#"
                                        id="navbarDarkDropdownMenuLink"
                                        role="button"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                    >
                                        {{ customer?.name }}
                                    </a>
                                    <ul
                                        class="dropdown-menu dropdown-menu-dark"
                                        aria-labelledby="navbarDarkDropdownMenuLink"
                                    >
                                        <li>
                                            <router-link
                                                class="dropdown-item"
                                                to="/profile"
                                                >Profile</router-link
                                            >
                                        </li>
                                        <li>
                                            <button
                                                class="dropdown-item"
                                                @click="logout"
                                            >
                                                Logout
                                            </button>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- account btn -->

                    <div v-else>
                        <router-link
                            class="btn btn-outline-primary"
                            to="/customerlogin"
                            >Login</router-link
                        >

                        <!-- <a href="#!" class="btn btn-primary ms-2 ms-lg-3"
                            >Sign Up</a
                        > -->
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <!-- /navigation -->
</template>

<script>
import { useAuthStore } from "../../store/authStore";
import { storeToRefs } from "pinia";

export default {
    setup() {
        const userStore = useAuthStore();
        const { customer, isAuthenticated } = storeToRefs(userStore);

        console.log(customer);

        return {
            customer,
            isAuthenticated,
            logout: userStore.logout,
        };
    },
};
</script>

<style scoped>
.nav-link {
    font-size: 16px;
}

.dropdown-menu {
    min-width: 150px;
}
</style>
