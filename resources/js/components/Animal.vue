<template>
    <div>
        <div class="nav bg-dark">
            <div class="ms-2 mt-2 mb-2 select-animal white">
                <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                </svg>
            </div>

            <!-- <div v-for="animal in animal_kinds" @click="getAnimal(animal.kind)" class="animal-circle mt-2 ms-2">
                <img class="animal-img" :id="animal.kind" :src="animal.img_path" :alt="animal.kind">
            </div> -->

            <div v-for="animal in animal_kinds" @click="showInputName(animal.kind)" class="animal-circle mt-2 ms-2">
                <img class="animal-img" :id="animal.kind" :src="animal.img_path" :alt="animal.kind">
            </div>
        </div>

        <div v-if="show_input_name" class="col-3 ms-2">
            <form>
                <div class="form-floating mt-3">
                    <input v-model="animal_name" type="text" class="form-control" id="floatingInput" placeholder="Назовите животное">
                    <label for="floatingInput">Назовите животное</label>
                </div>

                <input v-model="animal_kind" type="hidden">

                <div class="mt-3 mb-3">
                    <button @click.prevent="createAnimal(animal.kind)" class="btn btn-success">
                        <span v-if="loading" class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                        <span v-else>Сохранить</span>
                    </button>
                </div>
            </form>
        </div>

        <div class="container-fluid">
            <div class="row">
                <!-- <div v-for="animal_kind in animal_kinds" class="col-3 animal-img"> -->
                <div v-for="animal in animals" class="col-3 animal-img">
                    <img :src="animal.img_path" alt="">
                    <div>
                        

                        <h4 v-if="animal.name">
                            Имя: {{ animal.session.name }}
                        </h4>

                        <h5>
                            Возраст: {{ animal.age }}
                        </h5>

                        <h5>
                            Размер: {{ animal.size }}
                        </h5>
                    </div>
                </div>
                
            </div>
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
            show_input_name: false,
            animal_kinds: {},
            animal: [],
            animal_kind: '',
            animal_name: '',
            loading: false,

        }),

        mounted() {
            this.getAnimalKinds();
        },

        methods: {
            showInputName(kind) {
                this.show_input_name = true;
                this.animal_kind = kind;
            },

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
                        console.log(res.data);
                        this.getAnimal(res.data.session.kind)
                    })
            },

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