<script setup>
import { RouterLink, RouterView } from "vue-router";
</script>

<template>
    <nav class="navbar navbar-expand-lg bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand text-light" href="/about">Books</a>
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
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <RouterLink class="nav-link text-light" to="/"
                            >Home</RouterLink
                        >
                    </li>
                    <li class="nav-item">
                        <RouterLink class="nav-link text-light" to="/about"
                            >About</RouterLink
                        >
                    </li>
                    <li v-if="!isLoggedIn" class="nav-item">
                        <RouterLink class="nav-link text-light" to="/register"
                            >Register</RouterLink
                        >
                    </li>
                    <li v-if="!isLoggedIn" class="nav-item">
                        <RouterLink class="nav-link text-light" to="/login"
                            >Login</RouterLink
                        >
                    </li>

                    <div v-if="isLoggedIn" class="dropdown">
                        <button
                            class="btn btn-secondary dropdown-toggle"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            {{ loggedInUser.name }}
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <button
                                    @click="logout"
                                    class="dropdown-item"
                                    type="button"
                                >
                                Logout
                                </button>
                            </li>
                        </ul>
                    </div>
                </ul>

                <form class="d-flex" role="search">
                    <input
                        class="form-control me-2"
                        type="search"
                        placeholder="Search"
                        aria-label="Search"
                    />
                    <button class="btn btn-outline-light" type="submit">
                        Search
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <RouterView />
</template>
<script>
import axios from "axios";

export default {
    data() {
        return {
            isLoggedIn: false,
            loggedInUser: "",
        };
    },
    mounted() {
        this.checkLoginStatus();
    },

    methods: {
        checkLoginStatus() {
            axios
                .get("/isLogged")
                .then((response) => {
                    /* this.isLoggedIn = response.data.isLoggedIn; */
                    this.loggedInUser = response.data;
                    this.isLoggedIn = true;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        logout() {
            axios
                .post("/logout")
                .then((response) => {
                    this.isLoggedIn = false;
                    this.$router.push("/");
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>
<style>
nav a {
    margin-left: 30px;
}
</style>
