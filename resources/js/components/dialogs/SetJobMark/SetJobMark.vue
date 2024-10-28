<template>
    <v-dialog 
    v-model     = "isShowSetJobMark" 
    width="auto">
        <template #activator="{ on }">
            <v-tooltip top>
                <template v-slot:activator="{ on: tooltip  }">
                    <div class="selected_emoji_icon">
                        <v-img 
                        @click="toggleEmojiPicker"
                        v-on="tooltip"
                        :src="selectedEmoji"  
                        max-width="80px" 
                        max-height="80px" 
                        />
                    </div>
                </template>
                <span>Set mark</span>
            </v-tooltip>
        </template>
        <SetJobMarkCard v-if="isShowSetJobMark"/>
    </v-dialog>
</template>

<script>
    import store from '../../../store';
    import SetJobMarkCard from './SetJobMarkCard.vue';
    import {mapGetters,} from 'vuex/dist/vuex.common.js';
    export default {
        props: {
            taskId: {
                type: Number,
                required: true,
            }
        },
        data() {
            return {
                isShowSetJobMark: false,
                marksData: [
                    {iconName: 'bad_mark_icon.svg',    mark: 0,  description: 'I couldn\'t do it today'},
                    {iconName: 'normal_mark_icon.svg', mark: 50, description: 'I completed the task, but it could have been a bit better'},
                    {iconName: 'normal_mark_icon.svg', mark: 60, description: 'I completed the task, but it could have been a bit better'},
                    {iconName: 'good_mark_icon.svg',   mark: 99, description: 'I did a great job on the task'},
                ],
            };
        },
        store,
        computed: {
            ...mapGetters(['getTaskData']),
            jobMark() {
                return this.getTaskData(this.taskId, 'mark');
            },
            selectedEmoji() {
                const {iconName} = this.marksData.find(data => data.mark === this.jobMark);
                
                return `/images/marks/${iconName}`;
            },
        },
        components: {SetJobMarkCard},
        methods: {
            toggleEmojiPicker() {
                this.isShowSetJobMark = !this.isShowSetJobMark;
            }
        },
        created() {
            console.log(this.jobMark);
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