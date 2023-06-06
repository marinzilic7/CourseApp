<template>
    <div class="card" style="width: 18rem" v-for="course in courses" :key="course.id">
        <img
            class="card-img-top"
            :src="getImageUrl(course.image)"
            alt="Card image cap"
        />
        <div class="card-body">
            <h5 class="card-title">{{ course.naslov }}</h5>
            <p class="card-text">
               {{ course.body }}
            </p>
            <p>{{ course.category.name }}</p>
            <a href="#" class="btn btn-primary">Pogledaj kurs</a>
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
    data() {
        return {
            courses: [],
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
                    console.log(response.data)
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>
<style scoped>
/* .alert.alert-success{
    width:150px !important;
    float:right;
    height: 60px;
    text-align: center;
    margin-top:10px;
    margin-right: 20px;

} */
</style>
