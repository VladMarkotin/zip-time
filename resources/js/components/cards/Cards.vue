<template>
    <div>
        <div>{{title}}</div>
        <v-row class="cards_cards-wrapper">
            <v-col cols="6" v-for="item, i of items" v-bind:key="item.taskId">
                <Card 
                v-bind:item="item" 
                v-bind:num="i" 
                />
            </v-col>
        </v-row>
    </div>
</template>
<script>
    import Card from './Card.vue'

    export default {
    props : ['title','items'],
    components : {Card,},
    }
</script>

<style>
    @import url('/css/Cards/CardsMedia.css');
</style>