<template>
    <div class="container-fluid">
        <div class="row">
            <!-- <div v-for="animal_kind in animal_kinds" class="col-3 animal-img"> -->
            <div v-for="animal in animals" class="col-3 animal-img">
                <img :src="animal.img_path" alt="">
            </div>
        </div>
    </div>
</template>

<script>
    import axios from "axios";

    export default {
        props: ['animals'],

        data: () => ({
            // animals: []
        }),

        mounted() {

        },

        methods: {

        }
    }
</script>

<style scoped>
    .animal-img{
        padding-top: 10vh; 
    }

    img{
        width: 100%;
        height: inherit;
    }
</style>