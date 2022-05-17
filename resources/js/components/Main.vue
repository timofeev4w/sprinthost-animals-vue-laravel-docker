<template>
    <div>
        <v_header :onAnimal="onAnimal" :onAgeAnimals="onAgeAnimals"></v_header>
        <v_body :animals="animals" ></v_body>
    </div>
</template>

<script>
    import v_header from './Header.vue';
    import v_body from './Body.vue';

    export default {
        components: {
            v_header,
            v_body,
        },

        data: () => ({
            animals: [],
            aged: []
        }),

        methods: {
            onAnimal(data) {
                this.animals = data;
            },

            onAgeAnimals(data) {
                this.animals = data;
            }
        }
    }
</script>