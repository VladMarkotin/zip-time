<template>
    <v-menu 
    v-model="emojiPickerMenu" 
    offset-y transition="scale-transition"
    :close-on-content-click="false"
    >
        <template #activator="{ on }">
            <div class="selected_emoji_icon">
                <v-img 
                @click="emojiPickerMenu = true"
                :src="selectedEmoji"  
                max-width="80px" 
                max-height="80px" 
                />
            </div>
        </template>
        <v-card 
        class="p-2 m-0 d-flex flex-column align-items-center" 
        >
        <v-tabs 
        :value="jobMark"
        @change="sendMark" 
        hide-slider
        show-arrows
        >
            <v-tooltip 
            bottom 
            v-for="(data, idx) in emojiTabsData" 
            :key="idx"
            >
                <template v-slot:activator="{ on: tooltip  }">
                    <v-tab 
                    :tab-value = "data.mark"
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
                    {iconName: 'bad_mark_icon.svg', mark: 0, toopltipText: 'bad'},
                    {iconName: 'normal_mark_icon.svg', mark: 50, toopltipText: 'normal'},
                    {iconName: 'good_mark_icon.svg', mark: 99, toopltipText: 'good'},
                ],
            }
        },
        store,
        emits: ['sendMark'],
        computed: {
            ...mapGetters(['getTaskData']),
            selectedEmoji() {
                const {iconName} = this.emojiTabsData.find(data => data.mark === this.jobMark);
                
                return `/images/marks/${iconName}`;
            },

            jobMark() {
                return this.getTaskData(this.taskId, 'mark');
            }
        },
        methods: {
            sendMark(mark) {
                this.$emit('sendMark', mark);
                this.emojiPickerMenu = false;
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