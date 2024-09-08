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
                        color="red" 
                        :value="completedPercent">
                            {{ completedPercent }} %
                        </v-progress-circular>
                    </v-col>
                </v-row>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text class="details-cards-wrapper" :style="{ height: isMobile ? '450px' : '400px' }">
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
                            :subtaskRules                   = "detailsRules"
                            :detailTitleRules               = "detailTitleRules"
                            :detailTextRules                = "detailTextRules"
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
                                :counter="detailsRules.subtaskTitle.maxLength" 
                                label="Subtask title"
                                :rules="detailTitleRules"
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
                                :counter="detailsRules.subtaskText.maxLength"
                                label="Subtask details" 
                                :rules="detailTextRules"
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
                                        @addSubtask="addDetail"
                                        />
                                    </template>
                                    </v-col>
                                </v-row>
                            </v-col>
    
                        </v-row>
                        <v-divider></v-divider>
                        <v-row>
                            <template>
                                <v-expansion-panels>
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
                                                                    @click="showEditDetailsDialog(v)"
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
                :taskId                  = "taskId"
                :editableDetailId        = "editableDetailId"
                :subtaskRules            = "detailsRules"
                :detailTitleRules        = "detailTitleRules"
                :detailTextRules         = "detailTextRules"
                :alertDisplayTime        = "alertDisplayTime"
                @closeEditDetailsDialog  = "closeEditDetailsDialog"
                />
            </template>
        </v-card>
</template>

<script>
import store from '../../../store';
import { mapGetters, mapActions, mapMutations, } from 'vuex/dist/vuex.common.js';
import EditDetails from './EditDetails.vue';
import AddSubtaskButton from '../../UI/AddSubtaskButton.vue';
import EditButton from '../../UI/EditButton.vue';
import AddNewDetailMobile from './AddNewDetailMobile.vue';
import {mdiExclamation, mdiMarkerCheck, mdiDelete}  from '@mdi/js' 
    export default {
        props: {
            item: {
                type: Object,
                required: true,
            },
            taskId: {
                type: Number,
                required: true,
            },
            alert: {
                type: Object,
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
                detailsRules: {
                    subtaskTitle: {
                        minLength: 3,
                        maxLength: 255,
                    },
                    subtaskText: {
                        minLength: 0,
                        maxLength: 999,
                    }
                },
                detailTitleRules: [
                    (inputVal) => {
                        inputVal = inputVal ? inputVal.trim().length : 0;
                        const {minLength} = this.detailsRules.subtaskTitle;
                        return inputVal >= minLength || `Minimum length is ${minLength} characters`;
                    },

                    (inputVal) => {
                        inputVal = inputVal ? inputVal.trim().length : 0;
                        const {maxLength} = this.detailsRules.subtaskTitle;
                        return inputVal <= maxLength || `Maximum length is ${maxLength} characters`;
                    }
                ],
                detailTextRules: [
                    (inputVal) => {
                        inputVal = inputVal ? inputVal.trim().length : 0;
                        const {maxLength} = this.detailsRules.subtaskText;
                        return inputVal <= maxLength || `Maximum length is ${maxLength} characters`;
                    }
                ],
                dataOnValidofInputs: {
                    areAllInputsValValid: false,
                    isTitleInpuValValid:  false,
                    isTextInputValValid:  true,
                },
                editableDetailId: null,
                isShowEditDetailsDialog: false,
                isSavedTask: this.item.hash !== '#',
                radioButtons: [
                    {value: 'created-at-asc', label: 'Old first',},
                    {value: 'created-at-desc', label: 'New first',},
                    {value: 'is_ready-asc', label: 'Ready first',},
                    {value: 'unready-asc', label: 'Unready first',},
                ],
                isShowAddNewDetailMobileDialog: false,
            }
        },
        store,
        emits: ['closeAddDetailsDialog', 'updateAlertData', 'resetDayMarkToDefVal'],
        components: {EditDetails, AddSubtaskButton, EditButton, AddNewDetailMobile},
        watch: {
            'newDetail.title'() {
                this.setDataOnValidOfInputs(
                    'isTitleInpuValValid', 
                    this.detailTitleRules, 
                    this.newDetail.title
                );
            },
            'newDetail.text'() {
                this.setDataOnValidOfInputs(
                    'isTextInputValValid', 
                    this.detailTextRules, 
                    this.newDetail.text
                );
            }
        },
        computed: {
            ...mapGetters(['getDetailsData', 'getDetailsSortBy', 'getCompletedPercent', 'getMode']),
            detailsSortBy: {
                get() {
                    return this.getDetailsSortBy(this.taskId);
                },
                set(val) {
                    this.updateDetailsSortingCrit({key: this.taskId, newDetailsSortingCrit: val});
                }
            },
            details() {
                const currentTaskData = this.getDetailsData(this.taskId);

                if (!currentTaskData) {
                    return [];
                }
                const details = currentTaskData.details;
                const mode = this.displayedDetails.currentMode;

                if (mode === 'all') {
                    return details;
                }
                
                return details.filter(detail => !detail.is_old_compleated);
            },
            isMobile() {
                return this.screenWidth < 768; 
            },
            detailsSortingCrit() {
                return this.getDetailsSortingCrit(this.taskId);
            },
            completedPercent() {
                return this.getCompletedPercent(this.taskId);
            },  
            displayedDetails() {
                const currentMode = this.getMode(this.taskId);
                return {
                    currentMode,
                    all: {
                        showSubtasksButtonText: 'View actual subtasks'
                    },
                    actual: {
                        showSubtasksButtonText: 'View all subtasks',
                    }
                };
            }
        },
        methods: {
            ...mapActions(['addNewDetail', 'updateDetailsSortingCrit', 'updateCompletedStatus', 'deleteDetail' , 'fetchPersonalResults']),
            ...mapMutations(['SET_MODE']),

            updateAlertData(alertData) {
                this.$emit('updateAlertData', alertData);
            },

            getCurrentDate() {
                const date = new Date();

                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                const hours = String(date.getHours()).padStart(2, '0');
                const minutes = String(date.getMinutes()).padStart(2, '0');
                const seconds = String(date.getSeconds()).padStart(2, '0');

                return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
            },

            async addDetail(){
                if (this.dataOnValidofInputs.areAllInputsValValid) {

                    const created_at_date = new Date().getCurrentDate();

                    this.newDetail = {...this.newDetail, task_id: this.item.taskId, created_at_date: created_at_date, uniqKey: this.generateUniqKey(),};
                    
                    const response = await this.addNewDetail({newDetail: this.newDetail})
                    const respData = response.data;
                    
					this.isShowAlertInDetails = true;
                    this.checkResetDayMarkToDefVal(respData);
					this.$emit('updateAlertData', {type: respData.status === 'success' ? 'success' : 'error', text: respData.message});

                    this.newDetail = {
						title: '',
						text: '',
						position:1,
						weight: 100,
						checkpoint: false,
						is_ready: false,
                        created_at_date: '',
					};

                    this.isShowAddNewDetailMobileDialog = false;

                    setTimeout( () => {
						this.isShowAlertInDetails = false;
					},this.alertDisplayTime);
                } else {
					this.$emit('updateAlertData', {type: 'error', text: 'Invalid data'});
                    this.isShowAlertInDetails = true;
                    setTimeout( () => {
						this.isShowAlertInDetails = false;
					},this.alertDisplayTime)
                }
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

            async deleteSubTask(item){
                const detailId = item.taskId;
                const taskId   = this.taskId;
                const response = await this.deleteDetail({taskId, detailId});
                const respData = response.data;

                if (respData.status === 'success') {
                    this.isShowAlertInDetails = true;
                    this.updateAlertData({type: respData.status, text: 'subtask has been removed'});

                    setTimeout( () => {
                        this.isShowAlertInDetails = false;
					},this.alertDisplayTime)
                }
			},

            async completed(subtask){
                const taskId = this.item.taskId;
                try {
                    const response = await this.updateCompletedStatus({
                        subtask_id:          subtask.taskId, 
                        is_subtask_ready:    subtask.is_ready,
                        is_subtask_required: !!subtask.checkpoint,
                        task_id:             taskId,
                    })
                    
                    const respData = response.data;
                    if (respData.status === 'success') {
                        this.checkResetDayMarkToDefVal(response.data);
                    }
                } catch(error) {
                    console.error(error);
                }
			},

            showEditDetailsDialog(editableDetail) {
                this.editableDetailId = editableDetail.taskId;
                this.isShowEditDetailsDialog = true;
            },

            closeEditDetailsDialog() {
                this.isShowEditDetailsDialog = false;
            },

            showSubtasks() {
               const currentMode = this.displayedDetails.currentMode;

               const getNewModeVal = (currentMode) => {
                    switch(currentMode) {
                        case 'actual':
                            return 'all';
                        case 'all':
                            return 'actual';
                        default:
                            return 'all';
                    }
                };

                const newMode = getNewModeVal(currentMode);

                this.SET_MODE({key: this.taskId, newMode});
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

                    this.fetchPersonalResults(); 
                    //запрашиваю опять персональную статистику на случай если поле с отметкой было заполнено,
                    //но оно очистилось из-за добавления обязательной задачи
                }
            },

            setNewDetail(newDetail) {
                Object.assign(this.newDetail, newDetail);
            }
        },
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