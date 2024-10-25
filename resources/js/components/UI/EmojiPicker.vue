<template>
    <v-menu v-model="emojiPickerMenu" offset-y>
        <template #activator="{ props }">
            <v-img 
            @click="emojiPickerMenu = true"
            src="/images/marks/sad_mark_icon.svg"  
            max-width="80px" 
            max-height="80px" 
            />
        </template>
        <v-card 
        class="p-2 m-0 d-flex flex-column align-items-center" 
        width="300px"
        >
            <v-btn-toggle 
            color="white" 
            v-model="selectedEmoji"
            @change="sendMark"
            >
                <v-btn 
                v-for="(data, idx) in emojiButtonsData" 
                :key="idx"
                :value="data.markIconName"
                >
                    <v-img 
                    :src="`/images/marks/${data.markIconName}`"  
                    max-width="50px" 
                    max-height="50px"/>
                </v-btn>
            </v-btn-toggle>
        </v-card>
    </v-menu>
</template>

<script>
import { debounce } from 'lodash';
    export default {
        props: {
            taskId: {
                type: Number,
            }
        },
        data() {
            return {
                selectedEmoji: '',
                emojiPickerMenu: false,
            }
        },
        computed: {
            emojiButtonsData() {
                return [
                    {markIconName: 'sad_mark_icon.svg', value: 0, description: 'test1'},
                    {markIconName: 'happy_mark_icon.svg', value: 99, description: 'test2'},
                ];
            },
            getInitialSelectedEmojiVal() { //вытащу из стора
                return (taskId) => {
                    return 'happy_mark_icon.svg'
                }
            }
        },
        methods: {
            sendMark() {
                
            },
        },
        created() {
            this.selectedEmoji = this.getInitialSelectedEmojiVal(this.taskId);
        }
    }
</script>