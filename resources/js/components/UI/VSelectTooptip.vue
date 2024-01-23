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
            }
        },
        data() {
            return {
                icon: { mdiHelpCircleOutline },
            }
        },
        methods: {
            getText(type){
                const taskTypeInfo = {
                    requiredJob:
                    'Lorem ipsum dolor sit amet consectetur adipisicing elit. Illum iste exercitationem doloremque cumque esse ea ipsam odit, consectetur numquam animi vel assumenda optio,',
                    nonRequiredJob: 
                    'earum dolorem voluptate laudantium beatae voluptates ducimus alias velit a ullam. Fuga ex odit tempore odio saepe dolore aut deleniti, veniam assumenda repudiandae',
                    requiredTask:   
                    'totam sed voluptatem, exercitationem impedit! Cupiditate velit ea animi aliquid harum alias, mollitia excepturi nostrum eius magnam voluptate eum voluptatum nulla culpa,',
                    task:           
                    'ratione qui saepe temporibus recusandae beatae distinctio?',
                }

                //приходит строка с типом таски, трансформирую ее в CamelCase 
                const typeFormated = type.split(' ')
                    .map((word,index) => {
                    if (index === 0) return word;
                    return word[0].toUpperCase() + word.slice(1)
                    })
                    .join('');
                
                    return taskTypeInfo[typeFormated] || '';
                }
        }
    }
</script>

<style scoped>
    .activator-taskTypeTooltip.v-btn:focus::before {
      opacity: 0 !important;
    }
</style>