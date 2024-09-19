<template>
    <div>
        <div class="cards_type-img-wrapper">
            <CardsTypeImage 
                :title       = "title"
            />
        </div>
        <template>
            <transition-group name="slide-horizontal" tag="div" class="row cards_cards-wrapper">
              <v-col 
                v-for="(item, idx) in items" 
                :key="item.taskId" 
                cols="6"
              >
                <Card 
                  :taskId="item.taskId" 
                  :cardIdx="idx" 
                />
              </v-col>
            </transition-group>

</template>
    </div>
</template>
<script>
    import Card from './Card/Card.vue';
    import CardsTypeImage from '../UI/CardsTypeImage.vue';

    export default {
    props : ['title','items'],
    components : {Card, CardsTypeImage,},
    }
</script>

<style scoped>
    .cards_type-img-wrapper {
        padding: 30px 20px;
        margin-bottom: 15px;
        display: flex;
        justify-content: center;
        min-height: 188px;
    } 

    .slide-horizontal-enter-active, .slide-horizontal-leave-active {
        transition: transform 0.5s, opacity 0.5s;
    }

    .slide-horizontal-enter, .slide-horizontal-leave-to {
        transform: translateX(-10px);
        opacity: 0;
    }

    @import url('/css/Cards/CardsMedia.css');
</style>