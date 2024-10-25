<template>
    <v-menu v-model="emojiPickerMenu" offset-y>
        <template #activator="{ on }">
            <span @click="emojiPickerMenu = true">{{ selectedEmoji }}</span>
            <!-- <v-img 
            @click="emojiPickerMenu = true"
            :src="`/images/marks/${selectedEmoji}`"  
            max-width="80px" 
            max-height="80px" 
            /> -->
        </template>
        <v-card 
        class="p-2 m-0 d-flex flex-column align-items-center" 
        >
        <v-tabs 
        v-model="selectedEmoji" 
        @change="sendMark" 
        >
            <v-tab 
            v-for="(data, idx) in emojiTabsData"
            :key="idx"
            :tab-value = "data.iconName"
            >
                    <v-img 
                    :src="`/images/marks/${data.iconName}`"  
                    max-width="40px" 
                    max-height="40px" 
                    />
            </v-tab>
            <v-tabs-slider color="red"></v-tabs-slider>
        </v-tabs>
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
            emojiTabsData() {
                return [
                    {iconName: 'sad_mark_icon.svg', value: 0, status: 'bad'},
                    {iconName: 'sad2_mark_icon.svg', value: 0, status: 'normal'},
                    {iconName: 'happy_mark_icon.svg', value: 99, status: 'good'},
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
                console.log(selectedEmoji);
                
            },
        },
        created() {
            this.selectedEmoji = this.getInitialSelectedEmojiVal(this.taskId);
        }
    }
</script>