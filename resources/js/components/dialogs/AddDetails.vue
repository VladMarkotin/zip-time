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
        <v-card width="800">
        <v-card-title>
                <v-row>
                    <v-col>
                        <p class="text-xs-center">Plan`s details</p>
                    </v-col>
                    <v-col>
                        <v-progress-circular 
                        :rotate="360" 
                        :size="100" 
                        :width="10" 
                        :model-value="completedPercent"
                        color="red" 
                        :value="completedPercent">
                            {{ completedPercent }} %
                        </v-progress-circular>
                    </v-col>
                </v-row>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text style="height: 300px;">
                <template>
                    <v-row>
                        <v-col>
                            <v-text-field 
                            width="20px" 
                            v-model="subTasks.title" 
                            :counter="255" 
                            label="Subtask title"
                            v-on:keyup.enter="addDetail" 
                            :rules="subtaskTitleRules"
				            success
                            @input="checkInputsValue"
                            ref="subtaskTitleInput"
                            required></v-text-field>
                        </v-col>
                        <v-col>
                            <v-text-field 
                            width="20px" 
                            v-model="subTasks.text" 
                            v-on:keyup.enter="addDetail" 
                            :counter="999"
                            label="Subtask details" 
                            :rules="subtaskTextRules"
                            success
                            @input="checkInputsValue"
                            ref="subtaskTextInput"
                            required></v-text-field>
                        </v-col>
                        <v-col>
                            <v-checkbox 
                            label="is required subtask?" 
                            v-model="subTasks.checkpoint">
                            </v-checkbox>
                        </v-col>
                        <v-col>
                            <v-btn 
                            icon
                            v-if="isSubTasksInputValValid"
                            >
                                <v-icon md="1" color="#D71700" v-on:click="addDetail(item)"> {{ icons.mdiPlex }}
                                </v-icon>
                            </v-btn>
                        </v-col>

                    </v-row>
                    <v-divider></v-divider>
                    <v-row>

                        <template>
                            <!--Display subTask-->
                            <v-expansion-panels>
                                <v-expansion-panel v-for="(v, i) in details" :key="i">
                                    <v-expansion-panel-header>
                                        <p class="text-md-center">{{ v.title }} </p>
                                        <v-icon color="#D71700" v-if="v.checkpoint == 1">
                                            {{ icons.mdiExclamation }}

                                        </v-icon>
                                        <v-btn icon @click="editTask(v)">
                                            <v-icon color="#D71700">{{ icons.mdiPencil }}</v-icon>
                                        </v-btn>
                                        <v-icon color="#D71700" v-if="v.is_ready">
                                            {{ icons.mdiMarkerCheck }}
                                        </v-icon>
                                    </v-expansion-panel-header>
                                    <v-expansion-panel-content v-bind:class="{ done: v.is_ready }">
                                        <v-divider></v-divider>
                                        {{ v.text }}
                                        <v-row>
                                            <v-col>

                                                <v-checkbox v-model="v.is_ready" label="Is Ready?" color="red"
                                                    @change="completed(v)" hide-details></v-checkbox>
                                            </v-col>
                                            <v-col>

                                                <v-btn icon v-on:click="deleteSubTask(v)" v-if="v.checkpoint != 1">
                                                    <v-icon md="1" color="#D71700">
                                                        {{ icons.mdiDelete }}
                                                    </v-icon>
                                                </v-btn>
                                            </v-col>
                                        </v-row>
                                    </v-expansion-panel-content>

                                </v-expansion-panel>
                            </v-expansion-panels>
                        </template>
                    </v-row>
                </template>
            </v-card-text>
            <v-alert color="#404040" text class="elevation-1" v-bind:type="alert.type"
                v-if="isShowAlertInDetails">{{ alert.text }}</v-alert>
            <v-divider></v-divider>
            <v-card-actions>
                <v-row>
                    <v-col>
                        <v-btn color="blue-darken-1" variant="text" @click="dialogDetails = false">
                            Close
                        </v-btn>
                    </v-col>
                </v-row>
            </v-card-actions>
        </v-card>
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
import {mdiChartGantt, mdiPlex}  from '@mdi/js'  //m
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
            icons: {mdiChartGantt, mdiPlex},
            subTasks: {
						title: '',
						text: '',
						position:1,
						weight: 100,
						checkpoint: false,
						is_ready: false,
					},
            isShowAlertInDetails: false,
            subtaskRules: {
                subtaskTitle: {
                    minLength: 3,
                    maxLength: 255,
                },
                subtaskText: {
                    minLength: 0,
                    maxLength: 999,
                }
            },
            subtaskTitleRules: [
                (inputVal) => {
                    inputVal = inputVal.trim().length;
                    const {minLength} = this.subtaskRules.subtaskTitle;
                    return inputVal >= minLength || `Minimum length is ${minLength} characters`;
                },

                (inputVal) => {
                    inputVal = inputVal.trim().length;
                    const {maxLength} = this.subtaskRules.subtaskTitle;
                    return inputVal <= maxLength || `Maximum length is ${maxLength} characters`;
                }
            ],
            subtaskTextRules: [
                (inputVal) => {
                    inputVal = inputVal.trim().length;
                    const {maxLength} = this.subtaskRules.subtaskText;
                    return inputVal <= maxLength || `Maximum length is ${maxLength} characters`;
                }
            ],
            isSubTasksInputValValid: false,
        }
    },
    watch: {
       
    }, 
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

        updateAlertData(data) {
            this.$emit('updateAlertData', data);
		},

        updateCompletedPercent(compPercent) {
            this.$emit('updateCompletedPercent', compPercent);
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
                    const complPercentResp = response.data.completedPercent;
                    const completedPercent = (typeof complPercentResp === 'number') && !(Number.isNaN(+complPercentResp))
                                                ? complPercentResp
                                                : this.editCompletedPercet(complPercentResp);
                    
                    this.updateCompletedPercent(completedPercent);
                    this.updateAlertData(response.data.status, response.data.message);
				  })
			},

            addDetail(){
				this.subTasks.task_id = this.item.taskId
                this.updateDetails([...this.details, this.subTasks]);
				this.createSubPlan(this.subTasks)
				this.subTasks = {};
			},

			createSubPlan(item){
				axios.post('/add-sub-task',{task_id : item.taskId, hash: item.hash, sub_plan: item})
				.then((response) => {
					//console.log(response)
					this.isShowAlertInDetails = true;
					this.setAlertData(response.data.elements, response.data.message)
					this.completedPercent = response.data.completedPercent
					item.taskId = response.data.taskId
					setTimeout( () => {
						this.isShowAlertInDetails = false;
						//debugger;
					},3000)
				  })
				  .catch(function (error) {
					console.log(error)
				  })
			},

            checkInputsValue() {
                this.isSubTasksInputValValid = new Array(
                    ...this.subtaskTitleRules.map(check => check(this.subTasks.title)),
                    ...this.subtaskTextRules.map(check => check(this.subTasks.text)),
                ).every(checkResult => checkResult === true);
            },

    },
}
</script>