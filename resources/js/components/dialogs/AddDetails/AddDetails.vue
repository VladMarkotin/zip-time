<template>
    <v-dialog 
    :fullscreen = "isMobile" 
    v-model     = "isShowDialogDetails" 
    scrollable 
    width="auto">
        <template v-slot:activator="{ props }">
            <v-btn 
            icon 
            v-bind="props" 
            @click="getAllDetailsForTask(item)" 
            :id="!num ? 'card-details' : false"
            >
                <v-icon color="#D71700">{{ icons.mdiChartGantt }}</v-icon>
            </v-btn>
        </template>
        <template v-if="isShowDialogDetails">
            <AddDetailsCard 
            :item               = "item"
			:taskId             = "item.taskId"

            :alert              = "alert"
            :isLoading          = "isLoading"
            :generateUniqKey    = "generateUniqKey"
            :screenWidth        = "screenWidth"
            @updateDetails            = "updateDetails"
            @updateAlertData          = "setAlertData"

            @closeAddDetailsDialog    = "closeAddDetailsDialog"
            @showAllSubTasks          = "showAllSubTasks"
            @showActualSubTasks       = "getAllDetailsForTask"
            @resetDayMarkToDefVal     = "$emit('resetDayMarkToDefVal')"
            />
        </template>
    </v-dialog>
</template>

<script>
import store from '../../../store';
import { mapActions } from 'vuex/dist/vuex.common.js';
import AddDetailsCard from './AddDetailsCard.vue';
import {mdiChartGantt,}  from '@mdi/js'  
import { uuid } from 'vue-uuid';
export default {
    props: {
        num: {},
        item: {
            type: Object,
            required: true,
        },
        details: {
            type: Array,
            required: true,
        },
        completedPercent: {
            type: Number,
            required: true,
        },
        detailsSortingCrit: {
            type: String,
            required: true,
        },
        screenWidth: {
            type: Number,
        }
    },
    data() {
        return {
            isShowDialogDetails: false,
            isShowAllDialogDetails: false,
            alert: {type: 'success', text: 'success'},
            icons: {mdiChartGantt, },
            isLoading: false,
            minPreloaderDispTime: 500,
        }
    },
    store,
    components: {AddDetailsCard},
    watch: {
        isShowDialogDetails(isShowDialog) {
            if (!isShowDialog) this.$emit('resetSortingToDefVal');
        },
    },
    computed: {
      isMobile() {
            return this.screenWidth < 768; 
      }  
    },
    methods: {
        ...mapActions(['fetchDetails']),
        showAddDetailsDialog() {
            this.isShowDialogDetails = true;
        },

        closeAddDetailsDialog() {
            this.isShowDialogDetails = false;
        },

        showAllSubTasks(item) {
           this.getAllDetailsForTask(item, 'all')
        }, 

        updateDetails(details) {
            this.$emit('updateDetails', details);
        },

        // updateDetailsSortingCrit(sortCritVal) {
        //     this.$emit('updateDetailsSortingCrit', sortCritVal)
        // },

        setAlertData({type, text}) {
            if (type) this.alert.type = type;
            if (text) this.alert.text = text;
		},

        // updateCompletedPercent(compPercent) {
        //     this.$emit('updateCompletedPercent', compPercent);
        // },

        // checkCompletedPercent(complPercentResp) {
        //     return (typeof complPercentResp === 'number') && !(Number.isNaN(+complPercentResp))
        //             ? complPercentResp
        //             : this.editCompletedPercet(complPercentResp);
        // },

        // editCompletedPercet(compPercent) {
        //     if (typeof compPercent === 'string') {
        //         return +(compPercent.replace(/[^0-9.]/g,""));
        //     }
        //     return compPercent;
        // },

        async getAllDetailsForTask(item, mode=null) {
            
            const controllLoadingTime = (time, callback) => {
				if (time > this.minPreloaderDispTime) callback();
				else setTimeout(callback, this.minPreloaderDispTime - time);
			}
            
			this.showAddDetailsDialog();
            let data = {task_id : item.taskId}
            
            //mode means get all notes for all time 
            if(mode === 'all')  data.mode = 'all';

            this.isLoading = true;
            const loadingStart = Date.now();

            try {
                await this.fetchDetails({requestData: data, uniqKey: this.generateUniqKey()})

                const loadingEnd = Date.now();

                controllLoadingTime(loadingEnd - loadingStart, () => {
                    this.isLoading = false;
                });
                
            } catch (error) {
                console.error(error);
            }

			// axios.post('/get-sub-tasks',data)
			// .then((response) => {

            //     controllLoadingTime(loadingEnd - loadingStart, () => {
    
            //         const details = []
            //         response.data.data.forEach(element => {
            //             details.push({
            //                 title: element.title,
            //                 text:  element.text,
            //                 taskId: element.id,
            //                 is_ready: element.is_ready, 
            //                 checkpoint: element.checkpoint,
            //                 is_old_compleated: element.is_old_compleated,
            //                 done_at_user_time: element.done_at_user_time,
            //                 is_ready: element.is_ready,
            //                 uniqKey: this.generateUniqKey(),
            //                 created_at_date: element.created_at_user_time.slice(//получаю дату без времени
            //                     0, element.created_at_user_time.trim().indexOf(' ')
            //                 ),
            //             }) 
            //         });
            //         this.updateDetails(details);
            //         const completedPercent = this.checkCompletedPercent(response.data.completedPercent); 
                        
            //         this.updateCompletedPercent(completedPercent);
            //         this.setAlertData({type: response.data.status, text: response.data.message});
            //     });
			// 	})
		},

        generateUniqKey() {
             return uuid.v1();
        }
    },
}
</script>