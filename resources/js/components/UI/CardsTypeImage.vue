<template>
    <v-tooltip right>
        <template v-slot:activator="{on}">     
            <v-img 
                v-on="on" 
                max-height="128"
                max-width="128"
                class="card_type_img"
                :src="imageSrc"
                />
        </template>
        <span>{{title}}</span>
    </v-tooltip>
</template>

<script>
    export default {
        props : {
            title: {
                type: String,
            }
        },
        computed: {
            imageSrc() {
                return this.cardsTypeImageMap.get(this.title);
            }
        },
        data() {
           const cardsTypeImageMap = new Map;

           cardsTypeImageMap.set('Required tasks:', '/images/cards_required_image.png')
           cardsTypeImageMap.set('Non required tasks:', '/images/cards_nonRequired_image.png')

            return {
                cardsTypeImageMap,
            }
        }
    }
</script>