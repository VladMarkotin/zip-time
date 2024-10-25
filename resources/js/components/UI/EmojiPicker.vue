<template>
    <v-menu v-model="emojiPickerMenu" offset-y transition="scale-transition">
        <template #activator="{ on }">
            <v-tooltip right>
                <template v-slot:activator="{ on: tooltip  }">
                    <div class="selected_emoji_icon">
                        <v-img 
                        @click="emojiPickerMenu = true"
                        :src="`/images/marks/${selectedEmoji}`"  
                        v-on="tooltip"
                        max-width="80px" 
                        max-height="80px" 
                        />
                    </div>
                </template>
                <span>Set mark</span>
            </v-tooltip>
        </template>
        <v-card 
        class="p-2 m-0 d-flex flex-column align-items-center" 
        >
        <v-tabs 
        v-model="selectedEmoji" 
        @change="sendMark" 
        >
            <v-tooltip 
            bottom 
            v-for="(data, idx) in emojiTabsData" 
            :key="idx"
            >
                <template v-slot:activator="{ on: tooltip  }">
                    <v-tab 
                    :tab-value = "data.iconName"
                    v-on="tooltip"
                    >
                        <v-img 
                        :src="`/images/marks/${data.iconName}`"  
                        max-width="40px" 
                        max-height="40px" 
                        />
                    </v-tab>
                </template>
                <span>{{ data.toopltipText }}</span>
            </v-tooltip>
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
                    {iconName: 'sad_mark_icon.svg', value: 0, toopltipText: 'bad'},
                    {iconName: 'sad2_mark_icon.svg', value: 0, toopltipText: 'normal'},
                    {iconName: 'happy_mark_icon.svg', value: 99, toopltipText: 'good'},
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

<style scoped>
    .selected_emoji_icon {
        cursor: pointer;
        transition: all .3s ease;
        overflow: hidden;
    }

    .selected_emoji_icon:hover {
        transform: scale(1.05) rotate(5deg); 
    }
</style>