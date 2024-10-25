<template>
    <v-menu v-model="emojiPickerMenu" offset-y>
        <template #activator="{ on }">
            <!-- <h1>{{ selectedEmoji }}</h1> -->
            <v-img 
            @click="emojiPickerMenu = true"
            :src="`/images/marks/${selectedEmoji}`"  
            max-width="80px" 
            max-height="80px" 
            />
        </template>
        <v-card 
        class="p-2 m-0 d-flex flex-column align-items-center" 
        >
            <v-btn-toggle 
            color="white" 
            v-model="selectedEmoji"
            >
                <v-tooltip bottom v-for="(data, idx) in emojiButtonsData" :key="idx">
                    <template v-slot:activator="{ on: tooltip  }">
                        <v-btn 
                        v-on   = "tooltip"
                        :value = "data.iconName"
                        @click = "sendMark(data.iconName)"
                        >
                            <v-img 
                            :src="`/images/marks/${data.iconName}`"  
                            max-width="50px" 
                            max-height="50px"/>
                        </v-btn>
                    </template>
                    <span>{{data.tooltipText}}</span>
                </v-tooltip>
            </v-btn-toggle>
        </v-card>
    </v-menu>
</template>

<script>
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
                    {iconName: 'sad_mark_icon.svg', value: 0, tooltipText: 'test1'},
                    {iconName: 'happy_mark_icon.svg', value: 99, tooltipText: 'test2'},
                ];
            },
            getInitialSelectedEmojiVal() { //вытащу из стора
                return (taskId) => {
                    return 'happy_mark_icon.svg'
                }
            }
        },
        methods: {
            sendMark(selectedEmoji) {
                this.selectedEmoji = selectedEmoji;
            },
        },
        created() {
            this.selectedEmoji = this.getInitialSelectedEmojiVal(this.taskId);
        }
    }
</script>