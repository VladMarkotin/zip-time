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
            <v-card-text class="details-cards-wrapper" :style="{ height: isMobile ? '450px' : '400px' }">
                <!-- возможно удалить этот блок -->
                    <template>
                        <v-row 
                        class="m-0 p-0 addDetailsCard_addNewSubtaskBtn-wrapper d-flex justify-content-center align-items-center"
                        v-if="isMobile"
                        >
                            <v-btn
                            class="addDetailsCard_addNewSubtaskBtn-mobile addDetailsCard_btn"
                            @click="isShowAddNewDetailMobileDialog = true"
                            >
                                Add New Subtask
                            </v-btn>
                            <AddNewDetailMobile 
                            v-if="isShowAddNewDetailMobileDialog"
                            :isShowAddNewDetailMobileDialog = "isShowAddNewDetailMobileDialog"
                            :newDetail                      = "newDetail"
                            :subtaskRules                   = "subtaskRules"
                            :subtaskTitleRules              = "subtaskTitleRules"
                            :subtaskTextRules               = "subtaskTextRules"
                            :dataOnValidofInputs            = "dataOnValidofInputs"
                            @closeAddNewDetailMobileDialog  = "isShowAddNewDetailMobileDialog = false"
                            @setNewDetail                   = "setNewDetail"
                            @addSubtask                     = "addDetail"
                            />
                        </v-row>
                        <v-row 
                        v-else
                        class="addDetailsCard_addNewDetail-inputs-wrapper" 
                        >
                            <v-col
                            class="pb-0"
                            >
                                <v-text-field 
                                width="20px" 
                                v-model="newDetail.title" 
                                v-on:keyup.enter="addDetail" 
                                :counter="subtaskRules.subtaskTitle.maxLength" 
                                label="Subtask title"
                                :rules="subtaskTitleRules"
                                :success="dataOnValidofInputs.isTitleInpuValValid"
                                ref="subtaskTitleInput"
                                required></v-text-field>
                            </v-col>
                            <v-col
                            class="pb-0"
                            >
                                <v-text-field 
                                width="20px" 
                                v-model="newDetail.text" 
                                v-on:keyup.enter="addDetail" 
                                :counter="subtaskRules.subtaskText.maxLength"
                                label="Subtask details" 
                                :rules="subtaskTextRules"
                                :success="dataOnValidofInputs.isTextInputValValid"
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
                                        v-model="newDetail.checkpoint">
                                        </v-checkbox>
                                    </v-col>
                                    <v-col
                                    cols="4"
                                    class="d-flex flex-column align-items-start justify-content-start"
                                    >
                                    <template
                                    v-if="dataOnValidofInputs.areAllInputsValValid"
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
                                <v-expansion-panels v-if="!isLoading">
                                    <transition-group name="detailsList" tag="div" style="width: 100%;">
                                        <v-expansion-panel v-for="(v, i) in details" :key="v.uniqKey">
                                            <v-expansion-panel-header>
                                                <v-row class="p-0 m-0 addDetailsCard_accordion-header-wrapper">
                                                    <v-col
                                                    cols="9" 
                                                    class="p-0 m-0 d-flex justify-content-center align-items-center subtask-title-wrapper addDetailsCard_accordion-title-wrapper"
                                                    >
                                                        <div class="text-wrapper">
                                                            <p class="text-md-center">{{ v.title }} </p>
                                                        </div>
                                                    </v-col>
                                                    <v-col
                                                    cols="3" 
                                                    class="p-0 m-0 addDetailsCard_accordion-icons-wrapper"
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
                                                                <div v-show="!v.is_old_compleated">
                                                                    <EditButton 
                                                                    @click="createModifiedDetailTemplate(v)"
                                                                    :tooltipValue="'Edit subtask'"
                                                                    />
                                                                </div>
                                                            </template>
                                                            </v-col>
                                                            <v-col 
                                                            cols="4"
                                                            class="p-0 m-0 d-flex justify-content-center align-items-center"
                                                            >
                                                                <v-icon color="#D71700" v-if="v.is_ready" class="p-1">
                                                                    {{ icons.mdiMarkerCheck }}
                                                                </v-icon>
                                                            </v-col>
                                                        </v-row>
                                                    </v-col>
                                                </v-row>
                                            </v-expansion-panel-header>
                                            <v-expansion-panel-content 
                                            v-if="!v.is_old_compleated"
                                            v-bind:class="{ done: v.is_ready }"
                                            >
                                                <v-divider></v-divider>
                                                <v-row class="p-0 m-0 addDetailsCard_accordion-body-wrapper">
                                                    <v-col 
                                                    class="p-0 m-0 d-flex justify-content-center align-items-center subtask-detail-wrapper addDetailsCard_accordion-text-wrapper"
                                                    cols="9"
                                                    >
                                                        <div class="text-wrapper">
                                                            <p> {{ v.text }}</p>
                                                        </div>
                                                    </v-col>
                                                    <v-col 
                                                    class="p-0 m-0 addDetailsCard_accordion-body-buttons-wrapper"
                                                    cols="3"
                                                    >
                                                        <v-row class="m-0 pl-2">
                                                            <v-col class="p-0 m-0 d-flex flex-column justify-content-center align-items-center isReady-checkbox-wrapper">
                                                                <v-checkbox 
                                                                class="isReady-checkbox"
                                                                v-model="v.is_ready" 
                                                                :label="screenWidth > 550 ? 'Is Ready?' : ''" 
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
                                            <v-expansion-panel-content 
                                            v-else
                                            v-bind:class="{ done: v.is_ready }"
                                            >
                                                <v-divider></v-divider>
                                                <v-row class="p-0 m-0 addDetailsCard_accordion-body-wrapper">
                                                    <v-col 
                                                    class="p-0 m-0 d-flex justify-content-center align-items-center subtask-detail-wrapper addDetailsCard_accordion-text-wrapper"
                                                    cols="9"
                                                    >
                                                        <div class="text-wrapper">
                                                            <p> {{ v.text }}</p>
                                                        </div>
                                                    </v-col>
                                                    <v-col 
                                                    class="addDetailsCard_accordion-body-buttons-wrapper addDetailsCard_accordion-body-readySubtask"
                                                    cols="3"
                                                    >
                                                        <v-row class="p-0 m-0 d-flex justify-content-center align-items-center subtask-detail-wrapper">
                                                            <p class="completeon-date-text m-0">Completeon date:</p>
                                                        </v-row>
                                                        <v-row class="p-0 m-0 d-flex justify-content-center align-items-center subtask-detail-wrapper">
                                                            <p class="completeon-date-text m-0">{{ getSubtaskComptimeText(v.done_at_user_time) }}</p>
                                                        </v-row>
                                                    </v-col>
                                                </v-row>
                                            </v-expansion-panel-content>
        
                                        </v-expansion-panel>
                                    </transition-group>
                                </v-expansion-panels>
                                <v-row
                                v-else 
                                class="p-0 m-0 mt-6 d-flex justify-content-center align-items-center"
                                >
                                    <DefaultPreloader
                                    :size="96"
                                    :width="7"
                                    />
                                </v-row>
                            </template>
                        </v-row>
                    </template>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions style="min-height: 74px;" class="addDetailsCard-subtasks-radiobuttons-container">
                <v-row 
                v-if="details.length > 1"
                class="p-0 m-0 d-flex justify-content-center addDetailsCard_subtasks-radiobutoons-wrapper">
                    <v-col 
                    class="p-0 m-0 subtasks-radiobuttons-wrapper"
                    cols="auto"
                    >    
                        <v-radio-group 
                        v-model="detailsSortBy"
                        row
                        >
                            <v-radio
                            v-for="(button, index) in radioButtons"
                            :key="index"
                            class="subtasks-radiobutton"
                            :value="button.value"
                            color="red darken-3"
                            >
                                <template v-slot:label>
                                    <span class="radioButton-label">{{ button.label }}</span>
                                </template>
                            </v-radio>
                        </v-radio-group>
                    </v-col>
                </v-row>
            </v-card-actions>
            <v-card-actions>
                <v-row class="d-flex align-items-center justify-content-between p-0 m-0" id="addDetailsCard_card-footer">
                    <v-col
                    cols="4"
                    class="addDetailsCard_viewAll-button-wrapper"
                    >
                        <v-btn 
                        v-if="isSavedTask"
                        @click="showSubtasks"
                        color="blue-darken-1" 
                        variant="text" 
                        class="details-button addDetailsCard_btn"
                        >
                            {{ displayedDetails[displayedDetails.currentMode].showSubtasksButtonText}}
                        </v-btn>
                    </v-col>
                    <v-col class="details-alert-wrapper">
                        <transition
                        enter-active-class="details-alert_appearance"
                        leave-active-class="details-alert_leave"
                        >
                            <v-alert 
                            v-if="isShowAlertInDetails"
                            text class="elevation-1" 
                            v-bind:type="alert.type"
                            :class="'details-alert'"
                            >
                                {{ alert.text }}
                            </v-alert>
                        </transition>
                    </v-col>
                    <v-col
                    cols="3"
                    class="d-flex justify-content-end align-items-center addDetailsCard_close-button-wrapper"
                    >
                        <v-btn 
                        @click="$emit('closeAddDetailsDialog')"
                        color="blue-darken-1" 
                        variant="text" 
                        class="details-button addDetailsCard_btn"
                        >
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
import DefaultPreloader from '../../UI/DefaultPreloader.vue';
import AddNewDetailMobile from './AddNewDetailMobile.vue';
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
            },
            isLoading: {
                type: Boolean,
                required: true,
            },
            detailsSortingCrit: {
                type: String,
                required: true,
            },
            generateUniqKey: {
                type: Function,
            },
            screenWidth: {
                type: Number,
            }
        },
        data() {
            return {
                icons: {mdiExclamation, mdiMarkerCheck, mdiDelete},
                newDetail: {
						title: '',
						text: '',
						position:1,
						weight: 100,
						checkpoint: false,
						is_ready: false,
                        created_at_date: '',
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
                dataOnValidofInputs: {
                    areAllInputsValValid: false,
                    isTitleInpuValValid:  false,
                    isTextInputValValid:  true,
                },
                isShowEditDetailsDialog: false,
                isSavedTask: this.item.hash !== '#',
                modifiedDetailTemplate: {id: null, title: '', text: ''},
                displayedDetails: {
                    currentMode: 'actual',
                    all: {
                        showSubtasksButtonText: 'View actual subtasks'
                    },
                    actual: {
                        showSubtasksButtonText: 'View all subtasks',
                    }
                },
                detailsSortBy: null,
                radioButtons: [
                    {value: 'created-at-asc', label: 'Old first',},
                    {value: 'created-at-desc', label: 'New first',},
                    {value: 'is_ready-asc', label: 'Ready first',},
                    {value: 'unready-asc', label: 'Unready first',},
                ],
                isShowAddNewDetailMobileDialog: false,
            }
        },
        components: {EditDetails, AddSubtaskButton, EditButton, DefaultPreloader, AddNewDetailMobile},
        watch: {
            detailsSortBy(sortCritVal) {
                this.updateDetailsSortingCrit(sortCritVal);
            },
            'newDetail.title'() {
                this.setDataOnValidOfInputs(
                    'isTitleInpuValValid', 
                    this.subtaskTitleRules, 
                    this.newDetail.title
                );
            },
            'newDetail.text'() {
                this.setDataOnValidOfInputs(
                    'isTextInputValValid', 
                    this.subtaskTextRules, 
                    this.newDetail.text
                );
            }
        },
        computed: {
            isMobile() {
                return this.screenWidth < 768; 
            }  
        },
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

            updateDetailsSortingCrit(sortCritVal) {
                this.$emit('updateDetailsSortingCrit', sortCritVal)
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
                if (this.isLoading) return;

                if (this.dataOnValidofInputs.areAllInputsValValid) {

                    const dateNow = new Date;
                    const dataOpt = {year: 'numeric', month: 'numeric', day: 'numeric'};
                    const date = dateNow.toLocaleString("en-CA", dataOpt);

                    this.newDetail = {...this.newDetail, task_id: this.item.taskId, created_at_date: date, uniqKey: this.generateUniqKey(),};
                    this.updateDetails([...this.details, this.newDetail]);
                    this.createSubPlan(this.newDetail)
                    this.newDetail = {
						title: '',
						text: '',
						position:1,
						weight: 100,
						checkpoint: false,
						is_ready: false,
                        created_at_date: '',
					};
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
                    const respData = response.data;

					this.isShowAlertInDetails = true;
                    this.checkResetDayMarkToDefVal(respData);
					this.$emit('updateAlertData', {type: response.status === 200 ? 'success' : 'error', text: respData.message});
					const completedPercent = this.checkCompletedPercent(respData.completedPercent);
                    this.updateCompletedPercent(completedPercent);
					item.taskId = respData.subtaskId // ?
					setTimeout( () => {
						this.isShowAlertInDetails = false;
						//debugger;
					},this.alertDisplayTime)
				  })
				  .catch(function (error) {
					console.log(error)
				  })
			},

            setDataOnValidOfInputs(key, rules, inputVal) {
                this.dataOnValidofInputs[key] = 
                rules.map(check => check(inputVal))
                .every(checkResult => checkResult === true);

                this.checAllkInputsValue();
            },

            checAllkInputsValue() {
                const data = this.dataOnValidofInputs;

                data.areAllInputsValValid = [ data.isTitleInpuValValid, data.isTextInputValValid,]
                .every(checkResult => checkResult === true);
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

            completed(subtask){
                const taskId = this.item.taskId;
                const isSubtaskRequired = !!subtask.checkpoint;

				axios.post('/complete-sub-task',{
                    subtask_id : subtask.taskId, 
                    is_subtask_ready: subtask.is_ready,
                    is_subtask_required: isSubtaskRequired,
                    task_id: taskId,
                })
				.then((response) => {
                    const respData = response.data;
                    if (respData.status === 'success') {
                        this.checkResetDayMarkToDefVal(response.data);
                        this.updateCompletedPercent(this.editCompletedPercet(respData.completedPercent));
                        //раскомментить если хочу, что бы массив сортировался при клике на чекбокс
                        // this.updateDetailsSortingCrit(this.detailsSortBy); 
                    }
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
            },

            showSubtasks() {
               if (this.isLoading) return;
               const updateDispDataCurrentMode = (mode) => this.displayedDetails.currentMode = mode;

               switch(this.displayedDetails.currentMode) {
                    case 'actual':
                        updateDispDataCurrentMode('all');
                        this.$emit('showAllSubTasks', this.item);
                    break;
                    case 'all':
                        updateDispDataCurrentMode('actual');
                        this.$emit('showActualSubTasks', this.item);
                    break;
                    default:
                        updateDispDataCurrentMode('all');
                        this.$emit('showAllSubTasks', this.item);
               }

            },

            getSubtaskComptimeText(fullDate) {
                if (!fullDate) return '';

                const spaceIndex = fullDate.trim().indexOf(' ');

                if (spaceIndex === -1) {
                    return '';
                }

                const date = fullDate.slice(0, spaceIndex).replace(/-/g, '.');
                return date;
            },

            checkResetDayMarkToDefVal(respData) {
                const resetDayMarkToDefVal = 'resetDayMarkToDefVal';
    
                if (respData[resetDayMarkToDefVal]) {
                    this.$emit(resetDayMarkToDefVal);
                }
            },

            setNewDetail(newDetail) {
                Object.assign(this.newDetail, newDetail);
            }
        },

        created() {
            this.detailsSortBy = this.detailsSortingCrit
        },

        mounted() {
        // раскомментить, если хочу, что бы инпуты валидировались сразу после монтирования компоненты
        //    const subtasksInputs = [this.$refs.subtaskTitleInput, this.$refs.subtaskTextInput]
           
        //    if (subtasksInputs.every(item => item)) {
        //         subtasksInputs.forEach(item => item.validate(true));
        //         this.checAllkInputsValue();
        //    }
        }
    }
</script>

<style scoped>
    .details-cards-wrapper {
        position: relative;
    }

    .details-cards-wrapper::-webkit-scrollbar {
        width: 12px;
    }

    .details-cards-wrapper::-webkit-scrollbar-track {
        background: #e6e6e6;
        border-left: 1px solid #dadada;
    }

    .details-cards-wrapper::-webkit-scrollbar-thumb {
        background: #b0b0b0;
        border: solid 3px #e6e6e6;
        border-radius: 7px;
    }

    .details-cards-wrapper::-webkit-scrollbar-thumb:hover {
        background: rgb(161, 0, 0);
    }

    .isReqSubtask-checkbox-wrapper .v-input--checkbox {
        margin-top: 0;
    }

    .subtask-title-wrapper,
    .subtask-detail-wrapper {
        overflow: hidden;
        flex-grow: 1;
    }

    .subtask-title-wrapper > .text-wrapper {
        max-width: 300px;
    }
    .subtask-detail-wrapper > .text-wrapper {
        max-width: 400px;
    }

    .text-wrapper > p {
        margin-bottom: 0;
        word-wrap: break-word; 
        line-height: 1.2rem;
    }

    .isReady-checkbox-wrapper > .v-input--checkbox {
        margin-top: 0;
        padding-top: 0;
    }

    .completeon-date-text {
        text-align: center;
        color: rgba(0,0,0,.6);
        font-weight: bold;
    }

    .subtasks-radiobuttons-wrapper .v-input--selection-controls {
       padding: 0;
       margin: 0;
    }

    .radioButton-label {
        margin-bottom: 0;
        margin-top: 0.5rem;
    }

    .details-alert-wrapper {
        min-height: 60px; 
        padding: 0; 
        display: flex; 
        justify-content: center;
        align-items: center;
    }

    .details-alert {
        flex-grow: 1;
        margin-bottom: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 40px;
    }

    .details-alert_appearance {
      animation: .3s details_alert_appearance ease;
   	}

    .details-alert_leave {
        animation: .3s details_alert_leave ease;
    }

    .detailsList-enter-active, .detailsList-leave-active {
        transition: all 0.5s;
    }
    .detailsList-enter, .detailsList-leave-to {
        opacity: 0;
        transform: translateY(-20px);
    }

    .detailsList-move {
        transition: transform 0.3s;
    }
    .v-btn:not(.v-btn--round).details-button {
        min-width: 150px;
    }

    @keyframes details_alert_appearance {
		from { opacity: 0; left: -10px;}
		to { opacity: 1; left: 0;}
	}

	@keyframes details_alert_leave {
		from { opacity: 1; left: 0;}
		to { opacity: 0; left: 10px;}
	}

    @import url('/css/AddDetailsCard/AddDetailsCardMedia.css');
</style>