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
            />
        </template>
    </v-dialog>
    <!-- <v-dialog v-model="dialogEditSubTask" persistent width="500">

        <v-card>
            <v-card-title class="text-h5">
                Edit Subtask
            </v-card-title>
            <v-card-text>
                Edit Subtask`s title:
                <v-text-field class="ml-1" v-model="subTasks.title">

                </v-text-field>
                Edit Subtask`s text:
                <v-text-field class="ml-1" v-model="subTasks.text">

                </v-text-field>

            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="green-darken-1" variant="text" @click="dialogEditSubTask = false">
                    Cancel
                </v-btn>
                <v-btn color="green-darken-1" variant="text"
                    @click="saveChangesInSubtask({ title: subTasks.title, text: subTasks.text })">
                    Save
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog> -->
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

        getAllDetailsForTask(item) {
				this.showAddDetailsDialog();
				axios.post('/get-sub-tasks',{task_id : item.taskId})
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