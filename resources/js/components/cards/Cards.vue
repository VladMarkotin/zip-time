<template>
    <div>
        <div class="cards_type-img-wrapper">
            <CardsTypeImage 
                :title       = "title"
                :screenWidth = "screenWidth"
            />
            <!-- <v-tooltip right>
                <template v-slot:activator="{on}">     
                    <v-img 
                    v-on="on" 
                    max-height="128"
                    max-width="128"
                    class="card_type_img"
                    src="/images/cards_required_icon.png"
                    />
                </template>
            <span>{{title}}</span>
            </v-tooltip> -->
        </div>
        <v-row class="cards_cards-wrapper">
            <v-col cols="6" v-for="item, i of items" v-bind:key="item.taskId">
                <Card 
                v-bind:item="item" 
                v-bind:num="i" 
                v-bind:screenWidth = "screenWidth"
                />
            </v-col>
        </v-row>
    </div>
</template>
<script>
    import Card from './Card.vue';
    import CardsTypeImage from '../UI/CardsTypeImage.vue';

    export default {
    props : ['title','items', 'screenWidth'],
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