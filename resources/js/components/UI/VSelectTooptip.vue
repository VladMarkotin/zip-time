<template>
    <v-menu
    :nudge-right="55"
    :nudge-top="8"
    v-model="isMenuOpen"
    >
        <template v-slot:activator="{ on }">
            <v-btn 
            icon 
            v-on="on"
            class="activator-taskTypeTooltip"
            >
                <v-icon 
                color="#272421DD"
                md="1"
                > 
                    {{icon.mdiHelpCircleOutline}}
                </v-icon>
            </v-btn>
        </template>
        <transition
        appear
        enter-active-class="vselect-tooltip-appearance"
        >
            <v-card
            :min-height = minHeight
            :width      = width
            v-if="isMenuOpen"
            >
                <v-card-title class="justify-content-center">{{ item }}</v-card-title>
                <v-card-text>
                    <p class="text--primary text-justify mb-0" v-html="getText(item)"></p>
                </v-card-text>
            </v-card>
        </transition>
    </v-menu>
</template>

<script>
import { mdiHelpCircleOutline,} from '@mdi/js'
    export default {
        props: {
            width: {
                type: Number,
                default: 310
            },
            minHeight: {
                type: Number,
            },
            item: {
                type: String,
                required: true,
            },
            tooltipData: {
                type: Object,
                required: true,
            }
        },
        data() {
            return {
                icon: { mdiHelpCircleOutline },
                isMenuOpen: false
            }
        },
        methods: {
            getText(type){
                //приходит строка с типом таски, трансформирую ее в CamelCase 
                const typeFormated = type.split(' ')
                    .map((word,index) => {
                    if (index === 0) return word;
                    return word[0].toUpperCase() + word.slice(1)
                    })
                    .join('');
                
                    return this.tooltipData[typeFormated] || '';
                }
        }
    }
</script>

<style scoped>
    .activator-taskTypeTooltip.v-btn:focus::before {
      opacity: 0 !important;
    }

    .vselect-tooltip-appearance {
      animation: .3s vselect_tooltip_appearance ease;
   }

   @keyframes vselect_tooltip_appearance {
		from { left: 25px;}
		to { left: 0;}
	}
</style>