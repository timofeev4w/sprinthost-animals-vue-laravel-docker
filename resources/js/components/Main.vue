<template>
    <div>
        <v_header :onAnimal="onAnimal" ></v_header>
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
            // animal_kinds: {},
        }),

        methods: {
            onAnimal(data) {
                let overlap = 0;
                this.animals.forEach(element => {
                    if (element.kind == data.animal.kind) {
                        overlap++;
                    }
                });

                if (overlap == 0) {
                    this.animals.push(data.animal);
                }
                console.log(this.animals);
            },

            // onAnimalKinds(data) {
            //     this.animal_kinds = data;
            //     console.log(data);
            // },
        }
    }
</script>