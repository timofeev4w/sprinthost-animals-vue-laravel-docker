<template>
    <div class="container-fluid">
        <div class="row">
            <div v-if="animals.length != 0" class="row mt-3">
                <div class="d-flex justify-content-center">
                    <button @click="destroySession()" type="button" class="btn btn-danger">Начать заново</button>
                </div>
            </div>

            <div v-for="animal in animals" class="col-3 animal-img">
                <div class="d-flex justify-content-center">
                    <h4 >
                        Имя: {{ animal.name }}
                    </h4>
                </div>

                <div class="d-flex justify-content-center">
                    <h5>
                        Возраст: {{ animal.age }}
                    </h5>
                </div>

                <img 
                :src="animal.img_path" 
                :style="[{width : (animal.size/animal.max_size) * 100 + '%'},
                        animal.age == 1 ? {} : {transition: 'width 1.5s ease'}]">
            </div>
        </div>
    </div>
</template>

<script>
    import axios from "axios";

    export default {
        props: ['animals'],

        data: () => ({
            name: '',
        }),

        methods: {
            destroySession() {
                axios.post('api/animal/destroy')
                    .then(res => {
                        location.reload();
                    });
            }
        }
    }
</script>

<style scoped>
    .animal-img{
        padding-top: 10vh; 
    }

    img{
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
</style>