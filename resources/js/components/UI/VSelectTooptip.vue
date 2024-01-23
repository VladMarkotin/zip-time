<template>
    <v-menu
    :nudge-right="55"
    :nudge-top="8"
    >
        <template v-slot:activator="{ on, attrs }">
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
            <v-card
            min-height="200"
            width="300"
            >
                <v-card-title class="justify-content-center">{{ item }}</v-card-title>
                <v-card-text>
                    <p class="text--primary text-justify mb-0">
                        {{ getText(item) }}
                    </p>
                </v-card-text>
            </v-card>
    </v-menu>
</template>

<script>
import { mdiHelpCircleOutline,} from '@mdi/js'
    export default {
        props: {
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
</style>