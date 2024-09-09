<template>
    <v-tooltip 
        :right   = "tooltipPosition.right" 
        :bottom  = "tooltipPosition.bottom"
    >
        <template  v-slot:activator="{on}">     
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
import store from '../../store';
import { mapGetters } from 'vuex/dist/vuex.common.js';
    export default {
        props : {
            title: {
                type: String,
            },
        },
        computed: {
            ...mapGetters(['getWindowScreendWidth']),
            imageSrc() {
                return this.cardsTypeImageMap.get(this.title);
            },
            tooltipPosition() {
                const screenWidth = this.getWindowScreendWidth;
                return {
                    right:  screenWidth >= 768,
                    bottom: screenWidth < 768
                };
            }
        },
        data() {
           const cardsTypeImageMap = new Map;

           cardsTypeImageMap.set('Required jobs and tasks', '/images/cards_required_image.png')
           cardsTypeImageMap.set('Non required jobs and tasks', '/images/cards_nonRequired_image.png')

            return {
                cardsTypeImageMap,
            }
        },
    }
</script>