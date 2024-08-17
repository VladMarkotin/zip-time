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
            @closeAddDetailsDialog    = "closeAddDetailsDialog"
            @updateAlertData          = "setAlertData"
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
    emits: ['resetDayMarkToDefVal', 'getActualDetails'],
    components: {AddDetailsCard},
    computed: {
        isMobile() {
            return this.screenWidth < 768; 
        }  
    },
    watch: {
        isShowDialogDetails(value) {
            if (!value) {
                this.$emit('getActualDetails');
            }
        },
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

        setAlertData({type, text}) {
            if (type) this.alert.type = type;
            if (text) this.alert.text = text;
		},

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
                await this.fetchDetails({requestData: data})

                const loadingEnd = Date.now();

                controllLoadingTime(loadingEnd - loadingStart, () => {
                    this.isLoading = false;
                });
                
            } catch (error) {
                console.error(error);
            }
		},

        generateUniqKey() {
             return uuid.v1();
        }
    },
}
</script>