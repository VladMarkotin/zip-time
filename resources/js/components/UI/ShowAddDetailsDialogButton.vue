<template>
    <v-btn 
    icon 
    v-bind="props" 
    @click="getAllDetailsForTask(item)" 
    :id="!num ? 'card-details' : false"
    >
                <v-icon color="#D71700">{{ icons.mdiChartGantt }}</v-icon>
    </v-btn>
</template>

<script>
    import {mdiChartGantt, }  from '@mdi/js'  //m
    export default {
        props: {
            num: {},
        },
        data() {
            return {
                icon: {mdiChartGantt},
            }
        },
        methods: {
            
        },
    }
</script>