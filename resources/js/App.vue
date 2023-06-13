<script setup>
import { RouterLink, RouterView } from "vue-router";
</script>

<template>
    <nav class="navbar navbar-expand-lg bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand text-light" href="/">Courses</a>
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
                    <button
                        v-if="isLogged"
                        type="button"
                        class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#exampleModal"
                        data-bs-whatever="@mdo"
                    >
                        Add Course
                    </button>
                    <div
                        class="modal fade"
                        id="exampleModal"
                        tabindex="-1"
                        aria-labelledby="exampleModalLabel"
                        aria-hidden="true"
                    >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1
                                        class="modal-title fs-5"
                                        id="exampleModalLabel"
                                    >
                                        Add Course
                                    </h1>
                                    <button
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                        aria-label="Close"
                                    ></button>
                                </div>
                                <div class="modal-body">
                                    <form
                                        @submit.prevent="addCourse"
                                        method="POST"
                                    >
                                        <input
                                            type="hidden"
                                            v-model="this.POST"
                                        />
                                        <input
                                            type="hidden"
                                            name=""
                                            v-model="this.csrfToken"
                                        />
                                        <div class="mb-3">
                                            <label
                                                for="recipient-name"
                                                class="col-form-label"
                                                >Title:</label
                                            >
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="recipient-name"
                                                v-model="formData.naslov"
                                            />
                                        </div>
                                        <div class="mb-3">
                                            <label
                                                for="message-text"
                                                class="col-form-label"
                                                >Body:</label
                                            >
                                            <textarea
                                                class="form-control"
                                                id="message-text"
                                                v-model="formData.body"
                                            ></textarea>
                                        </div>
                                        <div class="input-group mb-3">
                                            <input
                                                type="file"
                                                class="form-control"
                                                id="inputGroupFile02"
                                                @change="imageChange"
                                            />
                                            <label
                                                class="input-group-text"
                                                for="inputGroupFile02"
                                                >Upload</label
                                            >
                                        </div>
                                        <div>
                                            <label for="category"
                                                >Kategorija:</label
                                            >
                                            <select
                                                id="category"
                                                v-model="formData.category_id"
                                                required
                                            >
                                                <option value="">
                                                    Odaberi kategoriju
                                                </option>
                                                <option
                                                    v-for="category in categories"
                                                    :value="category.id"
                                                    :key="category.id"
                                                >
                                                    {{ category.name }}
                                                </option>
                                            </select>
                                        </div>
                                        <button
                                            type="submit"
                                            class="btn btn-primary"
                                            id="odbjegliButton"
                                        >
                                            Add
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div
                            v-if="courseAdd"
                            class="alert alert-success"
                            role="alert"
                        >
                            {{ message }}
                        </div>
                    </div>
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

                <form
                    class="d-flex"
                    role="search"
                    @submit.prevent="searchCourse"
                >
                    <input
                        class="form-control me-2"
                        type="search"
                        placeholder="Search"
                        aria-label="Search"
                        v-model="searchText"
                    />
                    <button class="btn btn-outline-light" type="submit">
                        Search
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="hidePoruka">
        <div
            v-if="isLogged && porukaLog"
            class="alert alert-success"
            role="alert"
        >
            {{ porukaLog }}
        </div>
    </div>

    <RouterView />
</template>
<script>
import axios from "axios";
import { toDisplayString } from "vue";
export default {
    data() {
        return {
            isLoggedIn: false,
            loggedInUser: "",
            formData: {
                naslov: "",
                body: "",
                image: "",
                category_id: "",
            },
            csrfToken: "",
            POST: "",
            categories: [],
            message: "",
            courseAdd: false,
            searchText: "",
            search: false,
            hideCards: true,
        };
    },
    computed: {
        isLogged() {
            return this.$store.getters.getIsLogged; // Dohvaćamo varijablu putem getters-a
        },
        porukaLog() {
            return this.$store.getters.getPorukaLog;
        },
        filteredCourses() {
            if (!this.kurs) {
                return [];
            }
            return this.kurs.filter((course) => {
                return course.naslov
                    .toLowerCase()
                    .includes(this.searchText.toLowerCase());
            });
        },
    },
    mounted() {
        this.checkLoginStatus();
        this.getCategories();
       /*  const showPoruka = this.$route.query.poruka === "true";
        if (showPoruka) {
            let text = document.querySelector(".hidePoruka");
            setTimeout(() => {
                text.style.display = "none"; // Sakrijemo poruku nakon određenog vremena
            }, 1000);
        } */
    },
    methods: {
        fetchCsrfToken() {
            axios
                .get("/sanctum/csrf-cookie")
                .then((response) => {
                    this.csrfToken = response.data.csrf_token;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
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
        getCategories() {
            axios
                .get("/categories")
                .then((response) => {
                    this.categories = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        imageChange(event) {
            this.formData.image = event.target.files[0];
        },

        addCourse() {
            let formData = new FormData();
            formData.append("naslov", this.formData.naslov);
            formData.append("body", this.formData.body);
            formData.append("image", this.formData.image);
            formData.append("category_id", this.formData.category_id);

            axios
                .post("/addCourse", formData)
                .then((response) => {
                    this.message = response.data.message;
                    console.log(this.message);
                    this.courseAdd = true;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        searchCourse() {
            axios
                .get("/search", { params: { searchText: this.searchText } })
                .then((response) => {
                    const results = response.data.results;
                    this.search = true;
                    console.log(results);
                    /*  this.$router.push({ name: 'SearchResults', params: { results } }); */
                    this.$router.push({
                        name: "SearchResults",
                        query: { results: JSON.stringify(results) },
                    });
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>

<style>
#odbjegliButton {
    float: right;
    width: 100%;
    margin-top: 30px;
}

.hidePoruka {
    position: absolute;
    width: 10%;
    right: 0;
    margin-right: 30px;
    margin-top: 30px;
}
</style>
