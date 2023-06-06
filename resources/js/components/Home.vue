<template>
    <p v-if="delete" class="text-center text-danger">{{ deleteMessage }}</p>
    <div class="kartice">
        <div class="cards" v-for="course in courses" :key="course.id">
            <img :src="getImageUrl(course.image)" alt="" />
            <p>{{ course.naslov }}</p>
            <p>{{ course.body }}</p>
            <div class="buttons">
                <button class="btn btn-warning">UPDATE</button>
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
export default {
    data() {
        return {
            courses: [],
            delete:false,
            deleteMessage:'',
            form:{
                naslov:'',
                body:'',

            }
        };
    },
    mounted() {
        this.getCourse();
    },
    methods: {
        getImageUrl(imageName) {
            return `/ad_images/${imageName}`;
        },
        getCourse() {
            axios
                .get("/getCourse")
                .then((response) => {
                    this.courses = response.data;
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
                    this.delete = true
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>
<style scoped>
.kartice {
    display: flex;
}

.cards {
    border: 1px solid black;
    overflow-wrap: break-word;
    width: 20%;
    padding: 30px;
    text-align: justify;
    background-color: #f5f5f5;
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
</style>
