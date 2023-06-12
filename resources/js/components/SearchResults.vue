<template>
    <div>
        <h2>Rezultati pretrage:</h2>
        <div class="cards" v-for="result in searchResults" :key="result.id">

            <img :src="getImageUrl(result.image)" alt="" />
            <p>{{ result.naslov }}</p>
            <p>{{ result.body }}</p>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            searchResults: [], // Dodajte prazan niz za prikaz rezultata pretrage
        };
    },
    mounted() {
        this.searchResults = JSON.parse(this.$route.query.results); // Dobijte rezultate iz query parametra i pretvorite ih u objekat
    },
    methods:{
        getImageUrl(imageName) {
            return `/ad_images/${imageName}`;
        },
    }
};
</script>
<style>

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

</style>
