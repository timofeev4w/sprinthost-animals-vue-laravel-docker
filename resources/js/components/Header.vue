<template>
    <div class="nav bg-dark">
        <div class="ms-2 mt-2 mb-2 select-animal white">
            <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
            </svg>
        </div>

        <div v-for="animal in animal_kinds" @click="getAnimal(animal.kind)" class="animal-circle mt-2 ms-2">
            <img class="animal-img" :id="animal.kind" :src="animal.img_path" :alt="animal.kind">
        </div>
    </div>
</template>

<script>
    import axios from "axios";

    export default {
        props: [
            'onAnimal',
            'onAnimalKinds'
        ],

        data: () => ({
            animal_kinds: {},
            animal: []
        }),

        mounted() {
            this.getAnimalKinds();
        },

        methods: {
            getAnimalKinds() {
                axios.get('/api/animal_kinds')
                    .then(res => {
                        this.animal_kinds = res.data.message;
                        // console.log(this.animal_kinds);
                        // this.onAnimalKinds({
                        //     animal_kinds: this.animal_kinds
                        // })
                    })
            },

            getAnimal(kind) {
                axios.get('/api/animal/' + kind)
                    .then(res => {
                        this.animal = res.data;
                        this.onAnimal({
                            animal: this.animal.message
                        });
                    });
                
            },
        }
    }
</script>

<style scoped>
    .nav{
        color: white;
        width: 100vw;
    }

    .select-animal{
        cursor: pointer;
    }

    .animal-circle{
        overflow: hidden;
        cursor: pointer;
        background-color: white;
        border: 2px solid white;
        border-radius: 50%;
        height: 45px;
        width: 45px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .animal-img{
        height: 100%;
    }
</style>