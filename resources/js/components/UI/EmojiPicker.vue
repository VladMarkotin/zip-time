<template>
    <v-menu 
    v-model="emojiPickerMenu" 
    offset-x transition="scale-transition"
    :close-on-content-click="false"
    >
        <template #activator="{ on }">
            <v-tooltip top>
                <template v-slot:activator="{ on: tooltip  }">
                    <div class="selected_emoji_icon">
                        <v-img 
                        @click="emojiPickerMenu = true"
                         v-on="tooltip"
                        :src="selectedEmoji"  
                        max-width="80px" 
                        max-height="80px" 
                        />
                    </div>
                </template>
                <span>Update mark :)</span>
            </v-tooltip>
        </template>
        <v-card 
        class="p-2 m-0 d-flex flex-column align-items-center" 
        >
        <div class="mb-1 d-flex justify-content-end" style="width: 100%;">
                <v-tooltip right>
                    <template v-slot:activator="{ on: tooltip  }">
                        <v-btn 
                        v-on="tooltip"
                        icon 
                        @click="emojiPickerMenu = false"
                        >
                            <v-icon>mdi-close</v-icon>
                        </v-btn>
                    </template>
                    <span>Close</span>
                </v-tooltip>
        </div>
        <v-tabs 
        :value="jobMark"
        @change="sendMark" 
        hide-slider
        show-arrows
        >
            <v-tab 
            v-for="(data, idx) in emojiTabsData" 
            :tab-value="data.mark"
            :key="data.mark"
            >
                <v-img 
                :src="`/images/marks/${data.iconName}`"  
                max-width="40px" 
                max-height="40px" 
                />
            </v-tab>
            <v-tabs-items v-model="jobMark">
                <v-tab-item 
                    v-for="(data, idx) in emojiTabsData" 
                    :key="data.mark"
                    :value="data.mark"
                >
                    <v-card>
                        <v-card-text class="text-center">
                            {{data.description}}
                        </v-card-text>
                    </v-card>
                </v-tab-item>
            </v-tabs-items>
        </v-tabs>
        </v-card>
    </v-menu>
</template>

<script>
    import store from '../../store';
    import {mapGetters,} from 'vuex/dist/vuex.common.js';
    export default {
        props: {
            taskId: {
                type: Number,
                required: true,
            },
        },
        data() {
            return {
                emojiPickerMenu: false,
                emojiTabsData: [
                    { iconName: 'bad_mark_icon.svg', mark: 0, description: 'I couldn\'t do it today' },
                    { iconName: 'unsatisfied_mark_icon.svg', mark: 33, description: 'I worked on it, but the result is far from ideal' },
                    { iconName: '50%.png', mark: 50, description: 'I completed the task, but it could have been a bit better' },
                    { iconName: 'satisfied_mark_icon.svg', mark: 66, description: 'I did a good job and I\'m satisfied with the result' },
                    { iconName: 'excelent_mark_icon.svg', mark: 99, description: 'I did a great job on the task' },
                ],
            }
        },
        store,
        emits: ['sendMark'],
        computed: {
            ...mapGetters(['getTaskData']),
            selectedEmoji() {
                const found = this.emojiTabsData.find(data => data.mark === this.jobMark);
                const iconName = found ? found.iconName : this.emojiTabsData[0].iconName;
                return `/images/marks/${iconName}`;
            },

            jobMark() {
                return this.getTaskData(this.taskId, 'mark');
            }
        },
        methods: {
            sendMark(mark) {
                this.$emit('sendMark', mark);
            },
        },
        
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