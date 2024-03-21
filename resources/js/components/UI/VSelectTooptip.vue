<template>
    <v-menu
    :nudge-top="nudgeTop"
    :nudge-left="nudgeLeft"
    :nudge-right="nudgeRight"
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
                <v-card-title 
                :class="isShowDescription ? 'justify-content-center' : 'justify-content-center single-title'"
                >
                    {{ getText(item, 'titles') }}
                </v-card-title>
                <v-card-text  v-if="isShowDescription">
                    <p class="text--primary text-justify mb-0" v-html="getText(item, 'descriptions')"></p>
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
            },
            isShowDescription: {
                type: Boolean,
                default: true,
            },
            screenWidth: {
                type: Number,
            }
        },
        data() {
            return {
                icon: { mdiHelpCircleOutline },
                isMenuOpen: false
            }
        },
        computed: {
            isMobile() {
                return this.screenWidth < 768;
            },

            nudgeTop() {
                return this.isMobile ? 0 : 8
            },

            nudgeLeft() {
                return this.isMobile ? 215 : null
            },

            nudgeRight() {
                return this.isMobile ? null : 55
            }
        },
        methods: {
            getText(itemKey, mainKey){
                if (!this.tooltipData[mainKey]) return '';

                //приходит строка с типом таски, трансформирую ее в CamelCase 
                const keyFormated = itemKey.split(' ')
                    .map((word,index) => {
                    if (index === 0) return word;
                    return word[0].toUpperCase() + word.slice(1)
                    })
                    .join('');
                
                    return this.tooltipData[mainKey][keyFormated] || '';
                }
        },
    }
</script>

<style scoped>
    .activator-taskTypeTooltip.v-btn:focus::before {
      opacity: 0 !important;
    }

    .vselect-tooltip-appearance {
      animation: .3s vselect_tooltip_appearance ease;
   }

   .single-title {
    font-size: 1rem !important;
    padding: 7px 11px !important;
    line-height: normal;
   }

   @keyframes vselect_tooltip_appearance {
		from { left: 25px;}
		to { left: 0;}
	}
</style>