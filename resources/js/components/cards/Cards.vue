<template>
    <div>
        <div class="cards_type-img-wrapper">
            <CardsTypeImage 
                :title       = "title"
            />
        </div>
        <v-row class="cards_cards-wrapper">
            <v-col cols="6" v-for="item, idx of items" v-bind:key="item.taskId">
                <Card 
                :taskId="item.taskId" 
                :cardIdx="idx" 
                />
            </v-col>
        </v-row>
    </div>
</template>
<script>
    import Card from './Card.vue';
    import CardsTypeImage from '../UI/CardsTypeImage.vue';

    export default {
    props : ['title','items'],
    components : {Card, CardsTypeImage,},
    }
</script>

<style>
    .cards_type-img-wrapper {
        padding: 30px 20px;
        margin-bottom: 15px;
        display: flex;
        justify-content: center;
        min-height: 188px;
    } 

    @import url('/css/Cards/CardsMedia.css');
</style>