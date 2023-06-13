<template>
    <p v-if="delete" id="deleteMessage" class="text-center text-danger">
        {{ deleteMessage }}
    </p>
    <div class="kartice">
        <div class="cards" v-for="course in courses" :key="course.id">
            <img :src="getImageUrl(course.image)" alt="" />
            <p id="naslov">{{ course.naslov }}</p>
            <p id="bady">{{ course.body }}</p>
            <p id="name_category">{{ course.category.name }}</p>
            <p>{{ course.created_at }}</p>

            <div class="buttons">
                <button
                    type="button"
                    class="btn btn-warning"
                    data-bs-toggle="modal"
                    :data-bs-target="'#exampleModall' + course.id"
                    data-bs-whatever="@getbootstrap"
                    @click="openUpdateModal(course)"
                >
                    UPDATE
                </button>

                <div
                    class="modal fade"
                    :id="'exampleModall' + course.id"
                    tabindex="-1"
                    :aria-labelledby="'exampleModalLabell' + course.id"
                    aria-hidden="true"
                >
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1
                                    class="modal-title fs-5"
                                    :id="'exampleModalLabell' + course.id"
                                >
                                    Update course
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
                                    @submit.prevent="updateCourse(course.id)"
                                    method="POST"
                                >
                                    <input type="hidden" v-model="this.POST" />
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
                                            v-model="form.naslov"
                                        />
                                    </div>
                                    <div class="mb-3">
                                        <label
                                            for="message-text"
                                            class="col-form-label"
                                            >About course:</label
                                        >
                                        <textarea
                                            class="form-control"
                                            id="message-text"
                                            v-model="form.body"
                                        ></textarea>
                                    </div>
                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                        id="updateButton"
                                    >
                                        Update
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn btn-danger" @click="izbrisiKurs(course.id)">
                    DELETE
                </button>
            </div>
        </div>
    </div>
    <!-- -->
</template>

<script>
import axios from "axios";
import moment from "moment";

export default {
    data() {
        return {
            courses: [],
            delete: false,
            deleteMessage: "",
            form: {
                naslov: "",
                body: "",
            },
            csrfToken: "",
            POST: "",
            currentCourseId: null,
            date: "",
        };
    },

    mounted() {
        this.getCourse();
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
        getImageUrl(imageName) {
            return `/ad_images/${imageName}`;
        },
        getCourse() {
            axios
                .get("/getCourse")
                .then((response) => {
                    this.courses = response.data.map((course) => ({
                        ...course,
                        created_at: new Date(
                            course.created_at
                        ).toLocaleDateString("hr-HR", {
                            day: "numeric",
                            month: "long",
                            year: "numeric",
                        }),
                    }));
                    console.log(response.data);
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        izbrisiKurs(id) {
            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;
            axios
                .post(`/delete/${id} `)
                .then((response) => {
                    this.courses = this.courses.filter(
                        (course) => course.id !== id
                    );
                    this.deleteMessage = response.data.message;
                    this.delete = true;
                    this.hideMessage();
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        openUpdateModal(course) {
            this.currentCourseId = course.id; // Postavljamo trenutni ID kursa koji se ažurira
            this.form.naslov = course.naslov; // Postavljamo vrednost forme na trenutni naslov kursa
            this.form.body = course.body; // Postavljamo vrednost forme na trenuti opis kursa
            $("#exampleModall" + course.id).modal("show"); // Prikazujemo modal za ažuriranje kursa
        },
        updateCourse(id) {
            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;
            console.log(id);
            axios
                .post(`/update/${id} `, {
                    naslov: this.form.naslov,
                    body: this.form.body,
                })
                .then((response) => {
                    const updatedCourse = response.data.course;
                    const index = this.courses.findIndex(
                        (course) => course.id === this.currentCourseId
                    );
                    if (index !== -1) {
                        this.courses.splice(index, 1, updatedCourse);
                    }
                    $("#exampleModall" + this.currentCourseId).modal("hide"); // Sakrijemo modal za ažuriranje kursa
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        hideMessage() {
            setTimeout(() => {
                this.delete = false;
            }, 1000);
        },
    },
};
</script>
<style scoped>
.kartice {
    display: flex;
}

.cards {
    border: none;
    border-radius: 20px;
    overflow-wrap: break-word;
    width: 20%;
    padding: 30px;
    text-align: justify;
    background-color: #fff;
    margin-left: 20px;
    margin-top: 30px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
img {
    width: 200px;
    height: 100px;
}

.buttons {
    display: flex;
    justify-content: center;
    align-items: flex-end;
    margin-top: 20px;
}

.buttons button {
    margin-right: 20px;
}

#description {
    display: -webkit-box;
    -webkit-line-clamp: 2; /* Ograničava tekst na 3 reda */
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}

#updateButton {
    width: 100%;
}

#naslov {
    font-size: 25px;
    text-align: start;
}

#name_category {
    color: green;
}
</style>
