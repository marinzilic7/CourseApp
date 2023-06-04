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
                    <li v-if="!isLogged" class="nav-item">
                        <RouterLink class="nav-link text-light" to="/register"
                            >Register</RouterLink
                        >
                    </li>
                    <li v-if="!isLogged" class="nav-item">
                        <RouterLink class="nav-link text-light" to="/login"
                            >Login</RouterLink
                        >
                    </li>
                    <div v-if="isLogged" class="dropdown">
                        <button
                            class="btn btn-primary dropdown-toggle"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            {{ loggedInUser.name }}
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <button
                                    @click="odjaviSe"
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
    <div>
        <p>Is Logged {{ isLogged }}</p>

            <div v-if="isLogged && porukaLog" class="alert alert-success" role="alert">
                {{ porukaLog }}
            </div>

    </div>

    <RouterView />
</template>
<script>
import router from "./router";
import axios from "axios";
export default {
    data() {
        return {
            isLoggedIn: false,
            loggedInUser: "",

        };
    },
    computed: {
        isLogged() {
            return this.$store.getters.getIsLogged; // Dohvaćamo varijablu putem getters-a
        },
        porukaLog() {
            return this.$store.getters.getPorukaLog;
        },
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
        odjaviSe() {
            axios
                .post("/logout")
                .then((response) => {
                    this.isLoggedIn = false;
                    this.$store.dispatch("logout", false);
                    this.$router.push("/login");
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>

<style>
.alert.alert-success {
    width: 10%;
    float: right;
    margin-right: 30px;
}
</style>
