<template>
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
            <v-card-text style="height: 300px; position: relative;" >
                <!-- возможно удалить этот блок -->
                <div class="subtasks-inner-block"> 
                    <template>
                        <v-row>
                            <v-col
                            class="pb-0"
                            >
                                <v-text-field 
                                width="20px" 
                                v-model="subTasks.title" 
                                v-on:keyup.enter="addDetail" 
                                :counter="subtaskRules.subtaskTitle.maxLength" 
                                label="Subtask title"
                                :rules="subtaskTitleRules"
                                success
                                @input="checkInputsValue"
                                ref="subtaskTitleInput"
                                required></v-text-field>
                            </v-col>
                            <v-col
                            class="pb-0"
                            >
                                <v-text-field 
                                width="20px" 
                                v-model="subTasks.text" 
                                v-on:keyup.enter="addDetail" 
                                :counter="subtaskRules.subtaskText.maxLength"
                                label="Subtask details" 
                                :rules="subtaskTextRules"
                                success
                                @input="checkInputsValue"
                                ref="subtaskTextInput"
                                required></v-text-field>
                            </v-col>
                            <v-col
                            class="pb-0"
                            >
                                <v-row class="p-0 m-0">
                                    <v-col
                                    cols="8"
                                    class="d-flex flex-column align-items-center justify-content-start isReqSubtask-checkbox-wrapper"
                                    >
                                        <v-checkbox 
                                        label="is required subtask?" 
                                        v-model="subTasks.checkpoint">
                                        </v-checkbox>
                                    </v-col>
                                    <v-col
                                    cols="4"
                                    class="d-flex flex-column align-items-start justify-content-start"
                                    >
                                    <template
                                    v-if="isSubTasksInputValValid"
                                    >
                                        <AddSubtaskButton 
                                        :buttonSize="40"
                                        @addSubtask="addDetail(item)"
                                        />
                                    </template>
                                    </v-col>
                                </v-row>
                            </v-col>
    
                        </v-row>
                        <v-divider></v-divider>
                        <v-row>
    
                            <template>
                                <!--Display subTask-->
                                <v-expansion-panels>
                                    <v-expansion-panel v-for="(v, i) in details" :key="i">
                                        <v-expansion-panel-header>
                                            <v-row class="p-0 m-0">
                                                <v-col
                                                cols="9" 
                                                class="p-0 m-0 d-flex justify-content-center align-items-center subtask-title-wrapper"
                                                >
                                                    <p class="text-md-center">{{ v.title }} </p>
                                                </v-col>
                                                <v-col
                                                cols="3" 
                                                class="p-0 m-0"
                                                >
                                                    <v-row
                                                    class="m-0 pl-2 pr-4"
                                                    >
                                                        <v-col 
                                                        cols="4" 
                                                        class="p-0 m-0 d-flex justify-content-center align-items-center"
                                                        >
                                                        <v-tooltip bottom>
                                                            <template v-slot:activator="{ on: tooltip  }">
                                                                <v-icon
                                                                v-on="tooltip" 
                                                                color="#D71700" 
                                                                v-if="v.checkpoint == 1">
                                                                    {{ icons.mdiExclamation }}
                                                                </v-icon>
                                                            </template>
                                                            <span>This subtask has required status</span>
                                                        </v-tooltip>
                                                        </v-col>
                                                        <v-col 
                                                        cols="4"
                                                        class="p-0 m-0 d-flex justify-content-center align-items-center"
                                                        >
                                                        <template>
                                                            <EditButton 
                                                            @click="createModifiedDetailTemplate(v)"
                                                            :tooltipValue="'Edit subtask'"
                                                            />
                                                        </template>
                                                        </v-col>
                                                        <v-col 
                                                        cols="4"
                                                        class="p-0 m-0 d-flex justify-content-center align-items-center"
                                                        >
                                                            <v-icon color="#D71700" v-if="v.is_ready">
                                                                {{ icons.mdiMarkerCheck }}
                                                            </v-icon>
                                                        </v-col>
                                                    </v-row>
                                                </v-col>
                                            </v-row>
                                        </v-expansion-panel-header>
                                        <v-expansion-panel-content v-bind:class="{ done: v.is_ready }">
                                            <v-divider></v-divider>
                                            <v-row class="p-0 m-0">
                                                <v-col 
                                                class="p-0 m-0 d-flex justify-content-center align-items-center subtask-detail-wrapper"
                                                cols="9"
                                                >
                                                    <p> {{ v.text }}</p>
                                                </v-col>
                                                <v-col 
                                                class="p-0 m-0"
                                                cols="3"
                                                >
                                                    <v-row class="m-0 pl-2">
                                                        <v-col class="p-0 m-0 d-flex flex-column justify-content-center align-items-center isReady-checkbox-wrapper">
                                                            <v-checkbox 
                                                            class="isReady-checkbox"
                                                            v-model="v.is_ready" 
                                                            label="Is Ready?" 
                                                            color="red"
                                                            @change="completed(v)" 
                                                            hide-details></v-checkbox>
                                                        </v-col>
                                                        <v-col 
                                                        cols="2"
                                                        class="p-0 m-0 d-flex flex-column justify-content-center align-items-end"
                                                        >
                                                            <v-btn 
                                                            icon 
                                                            v-on:click="deleteSubTask(v)" 
                                                            v-if="v.checkpoint != 1">
                                                                <v-icon md="1" color="#D71700">
                                                                    {{ icons.mdiDelete }}
                                                                </v-icon>
                                                            </v-btn>
                                                        </v-col>
                                                    </v-row>
                                                </v-col>
                                            </v-row>
                                        </v-expansion-panel-content>
    
                                    </v-expansion-panel>
                                </v-expansion-panels>
                            </template>
                        </v-row>
                    </template>
                    <v-alert 
                    v-if="isShowAlertInDetails"
                    text class="elevation-1" 
                    v-bind:type="alert.type"
                    :class="'add-details-alert'"
                    >
                        {{ alert.text }}
                    </v-alert>
                </div>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
                <v-row class="d-flex align-items-center justify-content-end">
                    <v-col
                    cols="auto"
                    >
                        <v-btn color="blue-darken-1" variant="text" @click="$emit('closeAddDetailsDialog')">
                            Close
                        </v-btn>
                    </v-col>
                </v-row>
            </v-card-actions>
            <template v-if="isShowEditDetailsDialog">
                <EditDetails 
                :isShowEditDetailsDialog = "isShowEditDetailsDialog"
                :modifiedDetailTemplate  = "modifiedDetailTemplate"
                :details                 = "details"
                :subtaskRules            = "subtaskRules"
                :subtaskTitleRules       = "subtaskTitleRules"
                :subtaskTextRules        = "subtaskTextRules"
                :alertDisplayTime        = "alertDisplayTime"
                @closeEditDetailsDialog = "closeEditDetailsDialog"
                @updateDetails          = "updateDetails"
                />
            </template>
        </v-card>
</template>

<script>
import EditDetails from './EditDetails.vue';
import AddSubtaskButton from '../../UI/AddSubtaskButton.vue';
import EditButton from '../../UI/EditButton.vue';
import {mdiExclamation, mdiMarkerCheck, mdiDelete}  from '@mdi/js' 
    export default {
        props: {
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
            alert: {
                type: Object,
            }
        },
        data() {
            return {
                icons: {mdiExclamation, mdiMarkerCheck, mdiDelete},
                subTasks: {
						title: '',
						text: '',
						position:1,
						weight: 100,
						checkpoint: false,
						is_ready: false,
					},
                isShowAlertInDetails: false,
                alertDisplayTime: 1500,
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
                        inputVal = inputVal ? inputVal.trim().length : 0;
                        const {minLength} = this.subtaskRules.subtaskTitle;
                        return inputVal >= minLength || `Minimum length is ${minLength} characters`;
                    },

                    (inputVal) => {
                        inputVal = inputVal ? inputVal.trim().length : 0;
                        const {maxLength} = this.subtaskRules.subtaskTitle;
                        return inputVal <= maxLength || `Maximum length is ${maxLength} characters`;
                    }
                ],
                subtaskTextRules: [
                    (inputVal) => {
                        inputVal = inputVal ? inputVal.trim().length : 0;
                        const {maxLength} = this.subtaskRules.subtaskText;
                        return inputVal <= maxLength || `Maximum length is ${maxLength} characters`;
                    }
                ],
                isSubTasksInputValValid: false,
                isShowEditDetailsDialog: false,
                modifiedDetailTemplate: {id: null, title: '', text: ''},
            }
        },
        components: {EditDetails, AddSubtaskButton, EditButton},
        methods: {
            updateDetails(details) {
                this.$emit('updateDetails', details);
            },

            updateCompletedPercent(compPercent) {
                this.$emit('updateCompletedPercent', compPercent);
            },

            updateAlertData(alertData) {
                this.$emit('updateAlertData', alertData);
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

            addDetail(){
                if (this.isSubTasksInputValValid) {
                    this.subTasks.task_id = this.item.taskId
                    this.updateDetails([...this.details, this.subTasks]);
                    this.createSubPlan(this.subTasks)
                    this.subTasks = {};
                    this.checkInputsValue();
                } else {
					this.$emit('updateAlertData', {type: 'error', text: 'Invalid data'});
                    this.isShowAlertInDetails = true;
                    setTimeout( () => {
						this.isShowAlertInDetails = false;
					},this.alertDisplayTime)
                }
			},

			createSubPlan(item){
				axios.post('/add-sub-task',{task_id : item.taskId, hash: item.hash, sub_plan: item})
				.then((response) => {
					this.isShowAlertInDetails = true;
					this.$emit('updateAlertData', {type: response.status === 200 ? 'success' : 'error', text: response.data.message});
					const completedPercent = this.checkCompletedPercent(response.data.completedPercent);
                    this.updateCompletedPercent(completedPercent);
					item.taskId = response.data.taskId // ?
					setTimeout( () => {
						this.isShowAlertInDetails = false;
						//debugger;
					},this.alertDisplayTime)
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

            deleteSubTask(item){
                const removedTaskId = item.taskId;
                
				axios.post('/del-sub-task',{task_id : removedTaskId})
				.then((response) => {
                    if (response.data.status === 'success') {
                        this.isShowAlertInDetails = true;
                        this.updateAlertData({type: response.data.status, text: 'subtask has been removed'});
                        this.updateDetails(this.details.filter(item => item.taskId !== removedTaskId));
                        this.updateCompletedPercent(this.editCompletedPercet(response.data.completedPercent));
                        console.log(response.data);

                        setTimeout( () => {
                            this.isShowAlertInDetails = false;
					    },this.alertDisplayTime)
                    }
				})
			},

            completed(item){
				axios.post('/complete-sub-task',{task_id : item.taskId, is_task_ready: item.is_ready})
				.then((response) => {
                    console.log(response);
                    this.updateCompletedPercent(this.editCompletedPercet(response.data.completedPercent));
				})
			},

            createModifiedDetailTemplate(item) {
                this.modifiedDetailTemplate = {
                    id: item.taskId,
                    title: item.title,
                    text: item.text,
                }

                this.showEditDetailsDialog();
            },

            showEditDetailsDialog() {
                this.isShowEditDetailsDialog = true;
            },

            closeEditDetailsDialog() {
                this.isShowEditDetailsDialog = false;
            }
        },

        mounted() {

           const subtasksInputs = [this.$refs.subtaskTitleInput, this.$refs.subtaskTextInput]
           
           if (subtasksInputs.every(item => item)) {
                subtasksInputs.forEach(item => item.validate(true));
                this.checkInputsValue();
           }
        }
    }
</script>

<style scoped>
    .isReqSubtask-checkbox-wrapper .v-input--checkbox {
        margin-top: 0;
    }

    .subtask-title-wrapper,
    .subtask-detail-wrapper {
        overflow: hidden;
    }

    .subtask-title-wrapper > p,
    .subtask-detail-wrapper > p {
        word-wrap: break-word;
        margin-bottom: 0;
    }

    .isReady-checkbox-wrapper > .v-input--checkbox {
        margin-top: 0;
        padding-top: 0;
    }

    .subtasks-inner-block {
        width: 95%;
    }

    .add-details-alert {
        position: sticky; 
        left: 0; 
        bottom: 0; 
        z-index: 9999; 
        margin-bottom: 0;
        background-color: #DCDCDC !important;
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>