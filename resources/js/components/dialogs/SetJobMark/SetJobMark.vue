<template>
    <v-dialog 
    :fullscreen = "isShowFullScreen" 
    v-model     = "isShowSetJobDialog" 
    scrollable 
    persistent
    width="auto">
        <template #activator="{ on }">
            <v-tooltip right>
                <template v-slot:activator="{ on: tooltip  }">
                    <div class="selected_emoji_icon">
                        <v-img 
                        @click="showSetJobDialog"
                        v-on="tooltip"
                        :src="selectedEmoji"  
                        width="80px" 
                        height="80px" 
                        />
                    </div>
                </template>
                <span>{{selectedDescripTitle}}</span>
            </v-tooltip>
        </template>
        <SetJobMarkCard 
        v-if="isShowSetJobDialog"
        :marksData = "marksData"
        :cardTitle = "cardTitle"
        :mark      = "mark"
        @closeSetJobDialog  = "closeSetJobDialog"
        @sendMark           = "sendMark"
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
            },
            cardTitle: {
                type: String,
                default: '',
            },
            isUsedInTaskCard: {
                type: Boolean,
                default: false,
            },
            dayMark: {
                type: Number,
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
                        descriptionTitle: 'Today I didn\'t do it',
                        id: 1,
                    },
                    {
                        iconName: 'unsatisfied_mark_icon.svg', 
                        mark: 33, 
                        description: 'I worked on the task, but the result is still far from ideal. However, I\'m proud of myself for making progress and putting in the effort!',
                        descriptionTitle: 'Unsatisfied with the result.',
                        id: 2,
                    },
                    {
                        iconName: '35.svg',
                        mark: 35,
                        description: 'I made some progress, but there\'s still room for improvement. Every step forward counts!',
                        descriptionTitle: 'Making progress',
                        id: 3,
                    },
                    {
                        iconName: '41.svg',
                        mark: 41,
                        description: 'I\'m getting closer to my goal. The effort I put in is starting to show results.',
                        descriptionTitle: 'Getting closer',
                        id: 4,
                    },
                    {
                        iconName: '50.svg',
                        mark: 50,
                        description: 'I completed the task halfway. It\'s a solid foundation to build upon.',
                        descriptionTitle: 'Halfway there',
                        id: 5,
                    },
                    {
                        iconName: 'satisfied_mark_icon.svg', 
                        mark: 66, 
                        description: 'I did an excellent job with the task and I\'m completely satisfied with the result. It\'s always good to remind myself of my achievements and celebrate my hard work!',
                        descriptionTitle: 'Satisfied with the result',
                        id: 6,
                    },
                    {
                        iconName: '74.svg',
                        mark: 74,
                        description: 'I did really well! I\'m proud of what I accomplished and the quality of my work.',
                        descriptionTitle: 'Really good work',
                        id: 7,
                    },
                    {
                        iconName: '90.svg',
                        mark: 90,
                        description: 'I exceeded expectations! This is outstanding work that I can be truly proud of.',
                        descriptionTitle: 'Outstanding',
                        id: 8,
                    },
                    {
                        iconName: 'excelent_mark_icon.svg',   
                        mark: 99, 
                        description: 'Wow, I actually did even better than required! The key is to keep up this momentum and not stop at my current successes!',
                        descriptionTitle: 'excelent',
                        id: 9,
                    },
                ],
            };
        },
        emits: ['sendMark', 'showAlert'],
        store,
        computed: {
            ...mapGetters(['getTaskData', 'getWindowScreendWidth', 'getUnreadyReqDetails', 'getAllDetails']),
            mark() {
                if (this.isUsedInTaskCard && this.taskId) {
                    return this.getTaskData(this.taskId, 'mark');
                }
                return this.dayMark;
            },
            selectedEmoji() {
                const found = this.marksData.find(data => data.mark === this.mark);
                const iconName = found ? found.iconName : this.marksData[0].iconName;
                return `/images/marks/${iconName}`;
            },
            selectedDescripTitle() {
                const found = this.marksData.find(data => data.mark === this.mark);
                return found ? found.descriptionTitle : this.marksData[0].descriptionTitle;
            },
            isShowFullScreen() {
                return this.getWindowScreendWidth < 768; 
            },
            unreadyReqDetails() {
                if (this.isUsedInTaskCard && this.taskId) {
                    return this.getUnreadyReqDetails(this.taskId).length;
                }

                const tasksId = Object.keys(this.getAllDetails);
                return tasksId.reduce((accum, taskId) => {
                    return accum += this.getUnreadyReqDetails(taskId).length;
                }, 0);
            } 
        },
        components: {SetJobMarkCard},
        methods: {
            showSetJobDialog() {
                if (this.unreadyReqDetails) {
                    return this.$emit('showAlert',  {status: 'error', message: 'Error! Some required subtasks are still undone!'});
                }
                this.isShowSetJobDialog = true;
            },
            closeSetJobDialog() {
                this.isShowSetJobDialog = false;
            },
            sendMark(mark) {
                this.$emit('sendMark', mark);
                this.closeSetJobDialog();
            }
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