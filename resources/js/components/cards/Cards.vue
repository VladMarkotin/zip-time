<template>
    <div>
        <div class="cards_title-wrapper three"><h2>{{title}}</h2></div>
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
    import Card from './Card.vue'

    export default {
    props : ['title','items', 'screenWidth'],
    components : {Card,},
    }
</script>

<style>
.cards_title-wrapper {
  padding: 30px 20px;
  text-align: center;
} 

.cards_title-wrapper h2 {
  font-family: "Roboto", sans-serif;
  color: #fff;
  background: #A10000;
  font-size: 2.2rem;
  font-weight: normal;
  padding: 10px 40px;
  display: inline-block;
  margin: 0;
  line-height: 1;
  box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3);
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
}
    @import url('/css/Cards/CardsMedia.css');
</style>