<template>
    <v-dialog 
    v-model="isShowDialogDetails" 
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
            :item             = "item"
			:details          = "details"
			:completedPercent = "completedPercent"
            :alert            = "alert"
            @updateDetails          = "updateDetails"
            @updateAlertData        = "setAlertData"
            @updateCompletedPercent = "updateCompletedPercent"
            @closeAddDetailsDialog  = "closeAddDetailsDialog"
            @showAllSubTasks        = "showAllSubTasks(item)"
            />
        </template>
    </v-dialog>
</template>

<script>
import AddDetailsCard from './AddDetailsCard.vue';
import {mdiChartGantt,}  from '@mdi/js'  
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
        }
    },
    data() {
        return {
            isShowDialogDetails: false,
            isShowAllDialogDetails: false,
            alert: {type: 'success', text: 'success'},
            icons: {mdiChartGantt, },
        }
    },
    components: {AddDetailsCard},
    methods: {
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

        setAlertData({type, text}) {
            if (type) this.alert.type = type;
            if (text) this.alert.text = text;
		},

        updateCompletedPercent(compPercent) {
            this.$emit('updateCompletedPercent', compPercent);
        },

        checkCompletedPercent(complPercentResp) {
            return (typeof complPercentResp === 'number') && !(Number.isNaN(+complPercentResp))
                    ? complPercentResp
                    : this.editCompletedPercet(complPercentResp);
        },

        editCompletedPercet(compPercent) {
            if (typeof compPercent === 'string') {
                return +(compPercent.replace(/[^0-9.]/g,""));
            }
            return compPercent;
        },

        getAllDetailsForTask(item, mode=null) {
				this.showAddDetailsDialog();
                let data = {task_id : item.taskId}
                //mode means get all notes for all time 
                if(mode === 'all')  data.mode = 'all';
				axios.post('/get-sub-tasks',data)
				.then((response) => {
					const details = []
					response.data.data.forEach(element => {
                        details.push({
                            title: element.title,
							text:  element.text,
							taskId: element.id,
							is_ready: element.is_ready, 
							checkpoint: element.checkpoint
						}) 
					});
                    this.updateDetails(details);
                    const completedPercent = this.checkCompletedPercent(response.data.completedPercent); 
                    
                    this.updateCompletedPercent(completedPercent);
                    this.setAlertData({type: response.data.status, text: response.data.message});
				  })
			},
     

    },
}
</script>