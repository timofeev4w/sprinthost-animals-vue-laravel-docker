<template>
    <div>
        <div class="nav bg-dark">
            <div @click="showAnimalKinds" class="ms-2 mt-2 mb-2 select-animal white">
                <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                </svg>
            </div>

            <div v-if="show_animal_kinds" v-for="animal in animal_kinds" @click="showInputName(animal.kind)" class="animal-circle mt-2 ms-2">
                <img class="animal-img" :id="animal.kind" :src="animal.img_path" :alt="animal.kind">
            </div>
        </div>

        <div v-if="show_input_name" class="col-3 ms-2">
            <form>
                <div class="form-floating mt-3">
                    <input v-model="animal_name" type="text" class="form-control" id="floatingInput" placeholder="Назовите животное">
                    <label for="floatingInput">Назовите животное</label>
                </div>

                <small v-if="name_error" class="text-danger">Животному нужно имя!</small>

                <input v-model="animal_kind" type="hidden">

                <div class="mt-3 mb-3">
                    <button @click.prevent="createAnimal(animal.kind)" class="btn btn-success">
                        <span v-if="loading" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                        <span v-else>Сохранить</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

</template>

<script>
    import axios from "axios";

    export default {
        props: [
            'onAnimal',
            // 'onAnimalKinds',
            'onAgeAnimals'
        ],

        data: () => ({
            show_animal_kinds: false,
            show_input_name: false,
            name_error: false,
            animal_kinds: {},
            animals: [],
            animal: [],
            animal_kind: '',
            animal_name: '',
            loading: false,
            stop_age: false,
            timer: false

        }),

        mounted() {
            this.getAnimalKinds();
            this.checkSession();
        },

        methods: {
            showAnimalKinds() {
                this.show_animal_kinds = !this.show_animal_kinds;
            },
            // Get all animal kinds
            getAnimalKinds() {
                axios.get('/api/animal_kinds')
                    .then(res => {
                        this.animal_kinds = res.data.message;
                    });
            },

            // Check isset session
            checkSession() {
                axios.get('/api/animal/old')
                    .then(res => {
                        if (res.data.status) {
                            this.animals = res.data.data;
                            this.onAnimal(
                                this.animals, 
                            );
                            this.ageAnimals();
                        }
                    })
            },

            // Show name input field
            showInputName(kind) {
                this.show_input_name = true;
                this.animal_kind = kind;
            },

            // Create animal with name and save in session
            createAnimal() {
                this.loading = true;
                axios.post('/api/animal',
                    {
                        name: this.animal_name,
                        kind: this.animal_kind
                    })
                    .then(res => {
                        this.show_input_name = false;
                        this.loading = false;
                        this.animal_name = '';
                        this.name_error = false;
                        this.animals = res.data.data;

                        this.onAnimal(
                            this.animals, 
                        );

                        this.ageAnimals();
                    })
                    .catch(err => {
                        this.loading = false;
                        this.name_error = true;
                    })
            },

            // Age all animals
            ageAnimals() {
                if(!this.timer){
                    let aged = setInterval(() => {
                        axios.post('/api/animal/age')
                        .then(res => {
                            this.timer = true;
                            this.animals = res.data.data;
                            this.stop_age = res.data.stop;

                            if(this.stop_age) {
                                clearInterval(aged);
                                this.timer = false;
                                
                                this.stop_age = false;
                            };
                        });

                        this.onAgeAnimals(
                            this.animals
                        );
                    }, 1500);
                }
            }
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