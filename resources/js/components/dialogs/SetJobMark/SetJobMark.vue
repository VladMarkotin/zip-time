<template>
    <v-dialog 
    v-model     = "isShowSetJobDialog" 
    persistent
    width="auto">
        <template #activator="{ on }">
            <v-tooltip right>
                <template v-slot:activator="{ on: tooltip  }">
                    <div class="selected_emoji_icon">
                        <v-img 
                        @click="toggleSetJobDialog"
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
        <SetJobMarkCard 
        v-if="isShowSetJobDialog"
        :marksData = "marksData"
        @toggleSetJobDialog = "toggleSetJobDialog"
        />
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
                isShowSetJobDialog: false,
                marksData: [
                    {
                        iconName: 'bad_mark_icon.svg',    
                        mark: 0,  
                        description: 'Today I didn\'t do it, but I’m committed to learning from it and I know I\'ll succeed in the future.',
                        tickLabelDescription: 'Today I didn\'t do it',
                        id: 1,
                    },
                    {
                        iconName: 'normal_mark_icon.svg', 
                        mark: 33, 
                        description: 'I worked on the task, but the result is still far from ideal. However, I\'m proud of myself for making progress and putting in the effort!',
                        tickLabelDescription: 'Unsatisfied with the result.',
                        id: 2,
                    },
                    {
                        iconName: 'good_mark_icon.svg', 
                        mark: 66, 
                        description: 'I did an excellent job with the task and I\'m completely satisfied with the result. It\'s always good to remind myself of my achievements and celebrate my hard work!',
                        tickLabelDescription: 'Satisfied with the result',
                        id: 3,
                    },
                    {
                        iconName: 'best_mark_icon.svg',   
                        mark: 99, 
                        description: 'Wow, I actually did even better than required! The key is to keep up this momentum and not stop at my current successes!',
                        tickLabelDescription: 'excelent',
                        id: 4,
                    },
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
            toggleSetJobDialog() {
                this.isShowSetJobDialog = !this.isShowSetJobDialog;
            }
        },
        created() {
            // console.log(this.jobMark);
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