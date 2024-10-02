<template>
   <v-card id="plan-wrapper">
      <AddHashCode
      v-if="isShowAddHashCodeDialog"
      :width                = "450"
      :hashCodeVal          = "newHashCode"
      :isShowDialog         = "isShowAddHashCodeDialog"
      :taskName             = "defaultSelected.taskName"
      :time                 = "defaultSelected.time"
      :type                 = "defaultSelected.type"
      :priority             = "defaultSelected.priority"
      :details              = "defaultSelected.details"
      :notes                = "defaultSelected.notes"
      :defaultSavedTaskData = "defaultSavedTaskData"
      @close          = "closeHashCodeDialog"
      @changeHashCode = "changeHashCode"
      @addHashCode    = "addHashCode"
      />
      <v-card-title style="background-color: #A10000;color: white;" >Create your day plan!</v-card-title>
      <v-container>
         <div style="display: flex; justify-content: space-between;">
            <div>
               <PreplanDataPicker 
               v-model             = "planDate"
               :todayDate          = "todayDate"
               :emergencyModeDates = "emergencyModeDates"
               @changePlanDate = "changePlanDate"
               />
            </div>
            <div id="plan-day-status">
               <v-select
                  :items="dayStatuses2"
                  label="Day status"
                  v-model="day_status"
                  @change="isWeekendAvailable"
                  item-disabled="disable"
                  item-text="status"
                  required
                  ></v-select>
            </div>
         </div>
         <div style="min-height: 24px;">
            <transition name="tasks-counter">
               <div 
               v-if="items.length"
               class="tasks-counter-wrapper">
                  <p class="body-1 tasks-counter">{{ taskCounter }}</p>
               </div>
            </transition>
         </div>
         <v-divider></v-divider>
         <div>
            <v-row align="center" class="d-flex justify-content-between plan_inputs-wrapper">
               <v-col
                  md="3"
                  class="plan_code-input-wrapper"
                  >
                  <v-row class="p-0 m-0 d-flex justify-content-between"> 
                     <v-col
                     md="3" 
                     class="p-0 m-0 d-flex justify-content-center align-items-center plan_code-createCodeButton-wrapper"
                     >
                     <transition 
                     enter-active-class="button_appearance"
                     leave-active-class="button_leave"
                     >
                        <AddHashCodeButton 
                        v-if="defaultSelected.taskName.length > 3"
                        :tooltipPosition = "{bottom: true}"
                        :buttonSize      = "26"
                        @addHashCodeButtonClick="isShowAddHashCodeDialog = true"
                        />
                     </transition>
                     </v-col>
                     <v-col 
                     id="plan-hash"
                     class="p-0 m-0"
                     md="6"
                     >
                        <v-select
                           :items="defaultSelected.hashCodes"
                           value="defaultSelected.hashCodes[0]"
                           v-model="defaultSelected.hash"
                           @change="onChange(defaultSelected.hash, true)"
                           required>
                        </v-select>
                     </v-col>    
                     <v-col md="3" class="p-0 m-0 d-flex justify-content-center align-items-center plan_code-cleanCodeButton-wrapper">
                        <CleanHashCodeButton 
                        v-if="defaultSelected.hash.length > 1"
                        :tooltipPosition = "{bottom: true}"
                        :tooltipText     = "'Clear'"
                        @clearCurrentHashCode="clearCurrentHashCode"
                        />
                     </v-col>
                  </v-row>
               </v-col>
               <v-col 
               md="3"
               class="plan_taskName-input-wrapper"
               >
               <v-menu v-model="isShowPressEntTooltip" offset-y>
                  <template v-slot:activator="{ on }">
                     <v-text-field
                        v-on="on"
                        :placeholder=" placeholders[0] "
                        :counter="50"
                        required
                        v-model="defaultSelected.taskName"
                        ref="taskNameInput"
                        @input="inputChangeHandler"
                        @keypress.enter = "addTask"
                     >
                     </v-text-field>
                  </template>
                     <v-list v-show="screenWidth >= 1024">
                        <v-list-item style="justify-content: center; text-align: center;">Press Enter to add task<br/> to your daily plan.</v-list-item>
                     </v-list>
               </v-menu>
                 
               </v-col>
               <v-col md="2"
               class="plan_taskType-input-wrapper"
               >
                  <SelectTaskType 
                  :label="placeholders[1]"
                  :taskTypes="taskTypes"
                  v-model="defaultSelected.type"
                  />
               </v-col>
               <v-col 
               md="1"
               class="plan_taskPriority-input-wrapper"
               >
                  <v-select
                     :label="placeholders[2]"
                     required
                     :items="taskPriority"
                     v-model="defaultSelected.priority"
                     >
                     <template v-slot:item="{item}" >
                           <v-list-item >{{ item }}</v-list-item>
                           <!-- open-on-hover -->
                           <VSelectTooptip 
                           :item              = "item"
                           :width             = "200"
                           :tooltipData       = "tooltipPrioritiesData"
                           :isShowDescription = "false"
                           />
                     </template>
                  </v-select>
               </v-col>
               <v-col
               id="plan-time" 
               class="plan_time-input-wrapper"
               cols="1" 
               md="1">
                  <CustomTimepicker 
                  :time = "defaultSelected.time"
                  :isIconInner = "true"
                  @updateTime = "setTime"
                  />
               </v-col>
            
               <v-col md="1" class="plan_addTask-button-wrapper">
                  <v-tooltip bottom>
                     <template v-slot:activator="{ on }">
                        <div v-on="on">
                           <v-btn icon>
                              <v-icon md="1"
                                 color="#D71700"
                                 v-on:click="addTask"> {{icons.mdiPlex}}
                              </v-icon>
                           </v-btn>
                        </div>
                     </template>
                     <span>Add task to day plan</span>
                  </v-tooltip>
               </v-col>
            </v-row>
            <v-row 
            class="plan_addTask-button-wrapper_mobile p-2 m-0"
            >
               <v-btn
               class="plan_addTask-button_mobile"
               color="rgb(161, 0, 0)"
               dark
               @click="addTask"
               style="font-size: 18px; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);" 
               >
                  Add new task
               </v-btn>
            </v-row>
         </div>
         <v-divider></v-divider>
         <PreplanTasksTable 
         :items           = "items"
         :isShowPreloader = "showPreloaderInsteadTable"
         @deleteItem  = "deleteItem"
         />
         <v-row 
         class="d-flex justify-content-between align-items-center plan_footer"
         style="height: 80px;"
         >
         <v-col 
         class="d-flex justify-content-start align-items-center"
         cols="1"
         style="height: 100%;"
         >
            <div 
            id="plan-creating-wrapper"
            style="min-height: 36px; width: 36px;"
            v-if="!isShowProgress"
            >
            <transition
            enter-active-class="button_appearance"
            >
               <div 
               style="position: relative;"
               class=" d-flex justify-space-between" 
               v-if="!isTodayPlan || items.length > 0"
               >
               <v-tooltip right>
                     <template v-slot:activator="{ on, attrs }">
                        <v-btn 
                        id="plan-creating" 
                        v-on:click="formSubmit" 
                        v-bind="attrs"
                        v-on="on"
                        color="#D71700" 
                        style="text-color:#ffffff" 
                        icon 
                        >
                           <v-icon 
                           md="1"
                           color="#D71700"
                           large
                           >
                              {{icons.mdiClockStart}}
                           </v-icon>
                        </v-btn>
                     </template>
                     <span>Create plan</span>
                  </v-tooltip>          
               </div>
            </transition>
            </div>
            <div class="v-progress-circular" v-if="isShowProgress" style="height: inherit">
               <v-progress-circular
                  style="height: inherit"
                     :rotate="90"
                     :size="100"
                     :width="5"
                     :value="value"
                     color="red"
                     class="v-progress-circular"
                  >
                     {{ value }}
                  </v-progress-circular>
            </div>
         </v-col>
         <v-col 
         class="plan_alert-wrapper"
         cols="9"
         style="height: 100%;"
         >     
            <transition
            enter-active-class="create-day-alert_appearance"
            leave-active-class="create-day-alert_leave"
            >
               <v-alert
                  v-if="showAlert"
                  color="#404040"
                  text
                  class="elevation-1 create-day-alert mb-0 d-flex justify-content-center align-items-center plan_alert" 
                  :type="alertType"
                  >
                     {{serverMessage}}
                  </v-alert>
            </transition>
         </v-col>
         <v-col 
         class="d-flex justify-content-end align-items-center plan_emergency-mode-icon-wrapper"
         cols="1"
         style="height: 100%;"
         >
            <v-tooltip right>
                     <template v-slot:activator="{ on, attrs }">
                        <v-btn 
                        id="plan-emergency-mode" color="#D71700" style="text-color:#ffffff" icon v-on:click="toggleEmergencyCallDialog" v-bind="attrs"
                           v-on="on">
                           <v-icon md="1"
                              color="#D71700"
                              large
                              >
                              {{icons.mdiCarEmergency}}
                           </v-icon>
                        </v-btn>
                     </template>
                     <span>Emergency mode</span>
            </v-tooltip>
         </v-col>
         </v-row>
         
	      <EmergencyCall  
         v-if="isShowEmergencyCallDialog"
         v-on:toggleEmergencyCallDialog="toggleEmergencyCallDialog"/>
      </v-container>
   </v-card>
</template>
<script>
import store from '../../../store';
import PreplanDataPicker from '../../UI/PreplanDataPicker.vue';
import { mapMutations, mapGetters } from 'vuex/dist/vuex.common.js';
import AddHashCode from '../../dialogs/AddHashCode.vue';
import AddHashCodeButton from '../../UI/AddHashCodeButton.vue';
import CleanHashCodeButton from '../../UI/CleanHashCodeButton.vue';
import Vuetify from 'vuetify/lib'
import EmergencyCall from '../../dialogs/EmergencyMode/EmergencyCall.vue';
import PreplanTasksTable from './PreplanTasksTable.vue';
import VSelectTooptip from '../../UI/VSelectTooptip.vue';
import CustomTimepicker from '../../UI/CustomTimepicker.vue';
import SelectTaskType from '../../UI/SelectTaskType.vue';
import {
    mdiAccount,
    mdiPlex,
    mdiPencil,
    mdiShareVariant,
    mdiStarThreePointsOutline,
    mdiClockStart,
    mdiAlarm,
    mdiCarEmergency,
    mdiPlus,
    mdiPlusBox,
    mdiCancel,
} from '@mdi/js'
import { uuid } from 'vue-uuid';

import createWatcherForDefSavTaskMixin from '../../../mixins';
import details from '../../../store/modules/details';

export default {
   components : {
      EmergencyCall, 
      AddHashCode, 
      AddHashCodeButton, 
      CleanHashCodeButton, 
      PreplanTasksTable, 
      VSelectTooptip, 
      CustomTimepicker,
      SelectTaskType,
      PreplanDataPicker,
   },
   mixins: [createWatcherForDefSavTaskMixin('defaultSelected.hash')],
    data: () => ({
         planDate: new Date().getTodayFormatedDate(),
         todayDate: new Date().getTodayFormatedDate(),
         placeholders: ['Enter name of task here', 'Type', 'Priority', 'Time', 'Details', 'Notes'],
         newHashCode: '#',
         showIcon: 0,
         day_status: 'Work Day',
         menu: false/*for defaultSelected.time*/,
         isShowEmergencyCallDialog : false,
         defaultSelected: {
            hash: '#',
            hashCodes: [],
            taskName: '',
            time: '01:00',
            type: 'required job',
            priority: '1',
            details: '',
            notes: ''
         },
         items: [],
         icons: {
            mdiAccount,
            mdiPlex,
            mdiPencil,
            mdiStarThreePointsOutline,
            mdiClockStart,
            mdiAlarm,
            mdiPlus,
            mdiPlusBox,
            mdiCancel,
            mdiCarEmergency,
         },
         hashCodes: [],
         taskPriority: ['1', '2', '3'],
         dayStatuses: ['Work Day', 'Weekend'],
         dayStatuses2: [
            {
               status: 'Work Day',
               disable: false,
            },
            {
            status: 'Weekend',
            disable:false,
            }
         ],
         preparedTask: {},
         serverMessage: '',
         showAlert: false,
         alertType: 'success',
         isShowAddHashCodeDialog: false,
         isShowProgress: false,
         value: 0,
         interval: {},
         closeAlertTime: 0,
         showPreloaderInsteadTable: false,
         isShowPressEntTooltip: false,
         WEEKEND_DEFAULT_TASK_TYPE: 'task',
         WORKING_DAY_DEFAULT_TASK_TYPE: 'required job',
         defaultSavedTaskData: {
            isDefaultSAvedTaskSelected: false,
            defaultSavedTasks: [],
            selectedSavedTaskId: null,
         },
         addTaskToPlanWithoutConfirmation: false,
         emergencyModeDates: [],
    }),
    store,
    watch: {
      day_status() {
         const { hash } = this.defaultSelected;
         this.onChange(hash); 

         const tasksForTheDay = this.items.map(async task => {
            const { hash } = task;
            const isSavedTask = hash !== '#';

            if (!isSavedTask) {            
               return { ...task, type: this.WEEKEND_DEFAULT_TASK_TYPE};
            }

            try {
               const response = await axios.post('/getSavedTask', { hash_code: hash });
               const savedTaskType = response.data.type;
               const transformedTaskType = this.day_status === 'Work Day'
                  ? savedTaskType
                  : this.WEEKEND_DEFAULT_TASK_TYPE;
               
               return { ...task, type: transformedTaskType};
            } catch (error) {
               console.error(error);
               return task;
            }
         });

         Promise.all(tasksForTheDay).then(updatedItems => {
            this.items = updatedItems;
         }).catch(error => {
            console.error('Error processing tasks:', error); 
         });
      },
      },
    computed : {
        ...mapGetters(['getWindowScreendWidth']),
        screenWidth() {
            return this.getWindowScreendWidth;
        },
        taskTypes() {
            return this.isTodayAWeekend 
               ? [this.WEEKEND_DEFAULT_TASK_TYPE] 
               : ['required job', 'non required job', 'required task', 'task']
        },

         tooltipPrioritiesData() {
            return {
               titles: {
                  '1' : 'usual',
                  '2' : 'important',
                  '3' : 'extremly imortant',
               }
            }
         },

         taskCounter() {
            const tasksQuantity = this.items.length;

            return `There ${tasksQuantity > 1 ? 'are' : 'is'} ${tasksQuantity} ${tasksQuantity > 1 ? 'tasks' : 'task'} in your day plan`
         },

         isTodayAWeekend() {
				return this.day_status == 'Weekend';
		   },

         currentDayDefaultTaskType() {
            return this.isTodayAWeekend ? this.WEEKEND_DEFAULT_TASK_TYPE : this.WORKING_DAY_DEFAULT_TASK_TYPE;
         },

         isDefaultSavedTaskSelected() {
            return !!this.defaultSelected.hash.match(/^#q-/);
         },

         isTodayPlan() {
            return this.planDate === this.todayDate;
         },

    },
    methods: {
      ...mapMutations(['SET_WINDOW_SCREEN_WIDTH']),
      clearCurrentHashCode(){
			this.defaultSelected.hash = '#'
			this.defaultSelected.taskName = ''
			this.defaultSelected.type = this.currentDayDefaultTaskType;
			this.defaultSelected.priority = '1'
			this.defaultSelected.time = '01:00'
		},
       
        getPostParams() {
            return {
               date: this.planDate,
               day_status: {Weekend: 1, 'Work Day': 2}[this.day_status],
               plan: this.items,
            }; 
        },
        toggleEmergencyCallDialog(){
				this.isShowEmergencyCallDialog = !this.isShowEmergencyCallDialog
			},
        inputChangeHandler() {
            if (this.showIcon < 4) {
                this.showIcon += 1
            } 

        },
        isWeekendAvailable(item){
            let currentObj = this;
            axios.post('/isWeekendAvailable', {})
            .then(function(response) {
                  currentObj.dayStatuses2[1].disable = response.data.isWeekendAvailable
             })
            .catch(function(error) {
                    currentObj.output = error;
            });

        },

        async onChange(code, isFocusedTaskNameInput = false) {
         try {
               const currentObj = this;
               const isSavedTask = code !== '#';

               const getData = (response) => (key) => response.data[key];
               const response = await axios.post('/getSavedTask', { hash_code: code });
               // Функция для получения значения из ответа
               const getValue = getData(response);

               //Значение по умолчанию в инпуте с типом таски в зависимости от статуса дня
               const defaultTaskType = this.currentDayDefaultTaskType;
               //Если задача сохранена то инициализирую ее типом, а если нет, то типом по умолчанию
               const type = isSavedTask ? getValue('type') : defaultTaskType;
               //В выходной день тип все будет 'task'
               const selectedType = currentObj.day_status === 'Work Day' ? type : currentObj.WEEKEND_DEFAULT_TASK_TYPE;

               currentObj.defaultSelected.type = selectedType;

               if (isSavedTask) {
                     currentObj.defaultSelected.taskName = getValue('task_name');
                     currentObj.defaultSelected.priority = String(getValue('priority'));
                     currentObj.defaultSelected.details = getValue('details');
                     currentObj.defaultSelected.time = getValue('time');
                     currentObj.defaultSelected.notes = getValue('note');
               }

               if (this.screenWidth >= 1024 && isFocusedTaskNameInput) {
                     this.isShowPressEntTooltip = true;
               }

               if (isFocusedTaskNameInput) {
                     this.$refs.taskNameInput.focus();
               }
            } catch (error) {
               this.output = error;
            }
        },

        checkDefaultSelected() {
         let {taskName} = this.defaultSelected;
         taskName = taskName.trim();

         if (taskName.length < 4) {
            return 'The task\'s name must be more than 3 characters long';
         }

         if (taskName.length > 255) {
            return 'The task\'s name can\'t consist of more than 255 characters';
         }

         return true;
        },

        setAlert({serverMessage, alertType, checkTaskName = false}) {
            if (checkTaskName) {
               //если длина названия таски очень большая, то оставляю первые 25 символов только
               const regex = /The task (.+?) has/g;
               const matches = regex.exec(serverMessage);
               if (matches) {
                  const taskName = matches[1]; 
                  
                  if (taskName && taskName.length > 25) {
                     serverMessage = serverMessage.replace(taskName, taskName.slice(0,25) + '...');
                  }
               }
            }
         
            this.serverMessage = serverMessage;
            this.alertType = alertType;
            this.showAlert = true;

            clearTimeout(this.closeAlertTime);
            this.closeAlertTime = setTimeout(() => {
               this.showAlert = false;
            }, 5e3);
        },

        addTask() {
         // если пользователь пытается добавить в план дефолтную таску, то ему необходио сделать ее сохраненной
         if (this.isDefaultSavedTaskSelected) {
            this.isShowAddHashCodeDialog          = true;
            //после успешного создание хешкода таска попадет сразу в план
            this.addTaskToPlanWithoutConfirmation = true;
            return;
         }
         
         this.showAlert             = false;
         this.isShowPressEntTooltip = false;

         const checkTaskResult = this.checkDefaultSelected();
         const {taskName}      = this.defaultSelected;

         if (checkTaskResult !== true) {
            this.setAlert({serverMessage: checkTaskResult, alertType: 'error', checkTaskName: true});
            return;
         }

         this.items.push({...this.defaultSelected, uniqKey: this.generateUniqKey()});
         this.showIcon = 0;
         this.defaultSelected = {
               ...this.defaultSelected,
               hashCodes: this.defaultSelected.hashCodes,
               hash: '#',
               taskName: '',
               time: '01:00',
               type: this.currentDayDefaultTaskType,
               priority: '1',
               details: '',
               notes: ''
         }
            // если показываю алерт через метод setAlert и использую название таски, то важно для регулярки что бы текст был вида
            // The task .... has  (влияет на работу регулярки и обрезание большого названия таски)
         this.setAlert({serverMessage: `The task ${taskName} has been successfully added`, alertType: 'success', checkTaskName: true});
        },

        deleteItem(item) {
            const index = this.items.indexOf(item)
            const {taskName} = this.items[index];

            this.items.splice(index, 1);
             // если показываю алерт через метод setAlert и использую название таски, то важно для регулярки что бы текст был вида
            // The task .... has  (влияет на работу регулярки и обрезание большого названия таски)
            this.setAlert({serverMessage: `The task ${taskName} has been successfully removed`, alertType: 'success', checkTaskName: true});
        },

        async createPreplan() {
         try {

            const planData = this.getPostParams();

            const transformedPlan = planData.plan.map(data => ({
               hash:    data.hash,
               details: data.details,
               notes: data.notes,
               priority: data.priority,
               taskName: data.taskName,
               time: data.time,
               type: data.type,
               uniqKey: data.uniqKey,
            }));

            const response = await axios.post('/add-preplan', {
               plan:       transformedPlan,
               date:       planData.date,
               day_status: planData.day_status
            });

            this.setAlert({serverMessage: response.data.message, alertType: response.data.status});
         } catch(error) {
            console.error(error);
         }
        },

        formSubmit(e) {
            if (!this.isTodayPlan) {
               return this.createPreplan();
            }

            let currentObj = this;
            axios.post('/addPlan', currentObj.getPostParams())
            .then(function(response) { 
               const {status} = response.data;
               currentObj.alertType = response.data.status;
               currentObj.serverMessage = response.data.message;
               currentObj.showAlert = true;

               if (status === 'success') {
                     currentObj.isShowProgress = true;

                     currentObj.interval = setInterval(() => {
                      if (currentObj.value === 100) {
                         clearInterval(currentObj.interval)
                         return (currentObj.value = 100)
                      }
                         currentObj.value += 20
                      }, 500)
                     setTimeout(() => {
                         currentObj.showAlert = false
                         currentObj.isShowProgress = false
                         document.location.reload();
                     }, 5e3)
                  }  
                  
                  if (status === 'error') {
                     clearTimeout(currentObj.closeAlertTime);

                     currentObj.closeAlertTime = setTimeout(() => {
                        currentObj.showAlert = false;
                     }, 6000);

                  }

                })
                .catch(function(error) {
                    currentObj.output = error;
                });
        },

      changeHashCode(hashCodeVal) {
         this.newHashCode = hashCodeVal;
      },

      closeHashCodeDialog() {
         this.newHashCode = '#';
         this.isShowAddHashCodeDialog = false;
      },

      addHashCode() {
         this.defaultSelected.hashCodes.unshift(this.newHashCode);
         this.defaultSelected.hash = this.newHashCode;
         this.isShowAddHashCodeDialog = false;

         if (this.defaultSavedTaskData.isDefaultSAvedTaskSelected && this.addTaskToPlanWithoutConfirmation) {
            this.addTask();
         }
         this.addTaskToPlanWithoutConfirmation = false;
      },

      setTime(newTime) {
         this.defaultSelected.time = newTime;
      },

      generateUniqKey() {
         return uuid.v1();
      },

      updateScreenWidth() {
         this.SET_WINDOW_SCREEN_WIDTH({windowScreenWidth: window.innerWidth});
      },

      setTaskType(value) {
         console.log(value);
      },

      async getTodayPlan() {
         this.showPreloaderInsteadTable = true;

            try {
                  const response = await axios.post('/getPreparedPlan');
                  if (response) {
                     for (let i = 0; i < response.data.length; i++) {
                        const currentIterableTask = response.data[i];
                        if (Object.keys(currentIterableTask).length === 0) continue;

                        this.preparedTask.hash = currentIterableTask.hash_code;
                        this.preparedTask.taskName = currentIterableTask.task_name;
                        this.preparedTask.type = currentIterableTask.type;
                        this.preparedTask.priority = String(currentIterableTask.priority);
                        this.preparedTask.time = currentIterableTask.time;
                        this.preparedTask.details = currentIterableTask.details;
                        this.preparedTask.notes = currentIterableTask.note;
                        this.preparedTask.uniqKey = this.generateUniqKey();

                        this.items.push(this.preparedTask);
                        this.preparedTask = {};
                     }
                  }
            } catch (error) {
                  this.output = error;
            } finally {
                  this.showPreloaderInsteadTable = false;
            }
         },

         async getPreplan() {
            try {
               const response = await axios.post('/get-preplan', {date: this.planDate});
               
               if (response.status === 200) {
                  this.items = [...response.data.tasks, ...this.items];
                  this.day_status = response.data.transformed_day_status;
               }
            } catch(error) {
               console.error(error);
            }
         },

         async changePlanDate() {
            this.items = [];
            this.showPreloaderInsteadTable = true;

            const promises = [];

            if (this.isTodayPlan) {
               promises.push(this.getTodayPlan());
            }
            promises.push(this.getPreplan());

            await Promise.all(promises);
            
            this.showPreloaderInsteadTable = false;
         },

         async getEmergencyModeDates() {
            try {
               const response = await axios.post('/getEmergencyModeDates', {todayDate: this.todayDate});
               
               if (response.status === 200) {
                  return response.data.emergency_mode_dates;
               }
               return [];
            } catch(error) {
               console.error(error);
            }
         }
    },
    created() {
        let currentObj = this;

        axios.post('/getSavedTasks')
            .then(function(response) {
                 currentObj.defaultSelected.hashCodes = response.data.hash_codes;
                let length = response.data.hash_codes.length;
                for (let i = 0; i < length; i++) {
                    currentObj.defaultSelected.hashCodes[i] = currentObj.defaultSelected.hashCodes[i].hash_code
                }
                     axios.post('/getDefaultSavedTasks')
                     .then((response) => {
                        const {defaultSavedTasks} = response.data;
                        
                        currentObj.defaultSavedTaskData.defaultSavedTasks = defaultSavedTasks

                        if (defaultSavedTasks.length) {
                           defaultSavedTasks.forEach(defaultSavedTask => {
                              currentObj.defaultSelected.hashCodes = [...currentObj.defaultSelected.hashCodes, defaultSavedTask.hash_code];
                           })
                        }
                     })
                     .catch((error) => {
                        currentObj.output = error;;
                     })
            })
            .catch(function(error) {
                currentObj.output = error;
            });

         axios.post('/isWeekendAvailable')
         .then(function(response) {
            currentObj.dayStatuses2[1].disable = response.data.isWeekendAvailable
         })
         .catch(function(error) {
            currentObj.output = error;
         });

         currentObj.showPreloaderInsteadTable = true;

         Promise.all([this.getTodayPlan(), this.getPreplan()])
         .then(() => {
            currentObj.showPreloaderInsteadTable = false;
         });

        this.getEmergencyModeDates()
        .then((dates) => {
            this.emergencyModeDates = dates;
        })
        .catch((dates) => {
            this.emergencyModeDates = [];
        })
    },

    async mounted() {
      window.addEventListener('resize', this.updateScreenWidth); //для адаптива

      try {
         const response = await  axios.post('/getEduStep', {
			})
         let currentEduStep = response.data.edu_step;
         if (currentEduStep === 1){
					const introJS = require("intro.js").introJs();
               require("/css/customTooltip.css");
              
					introJS.setOptions({
                  tooltipClass: 'custom-tooltip',
                  hidePrev: true,
                  hideNext: true,
                  disableInteraction: true,
                  exitOnOverlayClick: false,
                  showStepNumbers: false,
                  steps: [
                  {  
                     tooltipClass: 'custom-tooltip first-slide',
                     intro: 'Hello, dear user! Now you will be explained, how to use some basic functional application «Quipl». We hope that we will manage to help you to plan your time efficiently and hope you will spend a good day with us!',
                  },
                  {  
                     element: document.getElementById('plan-wrapper'),
                     intro: 'This is so-called pre-plan. Here you can scetch you day plan. On this step you still can easily add/delete tasks.'
                  },
                  {
                     element: document.getElementById('plan-day-status'),
                     intro: 'Here you can easily manage day status.<br> We got 2 statuses: «Work day» and «Weekend».'
                  },
                  {
                     element: document.getElementById('plan-day-status'),
                     intro: 'You wouldn\'t be able to change it after plan\'s creating.'
                  },
                  {
                     element: document.getElementById('plan-hash'),
                     intro: 'This is hash code - the short task\'s name. After adding hash code to job/task, you would be able quickly add it to your plan with all settings.',
                     position: 'right',
                  },
                  {
                     element: document.getElementById('plan-time'),
                     intro: 'Here your can set job/task`s presumptive time. The crutial word is «presumptive». You can change this parameter at any time. Also you can close job/task much later/earlier',
                     position: 'left',
                  },
                  {
                     element: document.getElementById('plan-tasks-table'),
                     intro: 'Here your would see jobs/tasks which have already been added. On this step you can easily add/delete/change any of them. After your plan had been created, cancel job/task would be imposible.',
                     position: 'left',
                  }, 
                  {
                     element: document.getElementById('plan-tasks-table'),
                     intro: 'But why so severely? This approach is the best way to instill responsibility. This motivates you to think through your plans and, most importantly, bring them to completion.',
                     position: 'left',
                  }, 
                  {  
                     element: document.getElementById('plan-creating'),
                     intro: 'Right now you will be able to form your day plan. Pay attention that it should consist of no less than two required jobs.',
                  },
                  {  
                     element: document.getElementById('plan-emergency-mode'),
                     intro: 'This button makes «emergency mode» active. You may use it in the occasions when you can\'t close your day plan.',
                  },
                  {  
                     element: document.getElementById('plan-emergency-mode'),
                     intro: 'In this case, day plan would be absolutly reset, your rating wouldn`t be reduced. In the next step you would also be able to activate it but, again, emergency mode reset(!) all your day progress.',
                  },
                  ]
               }).onbeforechange((elem) => {
                  const currentStepIndex = introJS._currentStep;

                  if (![6,7,8,].includes(currentStepIndex) && this.items.length) {
                     this.items = [];
                  }

                  if (![4,5,6,7,8,].includes(currentStepIndex) && this.defaultSelected.hash !== '#') {
                     this.defaultSelected = {
                     hash: '#',
                     hashCodes: this.defaultSelected.hashCodes,
                     taskName: '',
                     time: '01:00',
                     type: 'required job',
                     priority: '1',
                     details: '',
                     notes: ''
                     };
                  }

               }).onafterchange(() => {
                  const currentStepIndex = introJS._currentStep;
                  const lastStepIndex = introJS._introItems.length - 1;

                  const addWelcomeBlock = () => {
                     const mainIntroTooltipBlock =  document.querySelector('.custom-tooltip')
                     const customBlock = document.createElement('div');
                     customBlock.classList.add('welcome-block');
                     
                     mainIntroTooltipBlock.insertBefore(customBlock, mainIntroTooltipBlock.querySelector('.introjs-tooltiptext'));
                  }

                  const welcomeBlock = document.querySelector('.welcome-block');
                  if (currentStepIndex === 0 && !welcomeBlock) {
                     addWelcomeBlock()
                     introJS.goToStepNumber(currentStepIndex + 1);
                  };
                  if (currentStepIndex !== 0 && welcomeBlock) {
                     welcomeBlock.remove();
                  }


                  const checkDefaultTasks = () => {
                     const defaultTasks = this.defaultSelected.hashCodes.filter(hash => hash.match(/^#q-/))  
                     if (defaultTasks.length) return defaultTasks[0];

                     return this.defaultSelected.hashCodes.length ? this.defaultSelected.hashCodes[0]: null;
                  }

                  const shownTaskHash = checkDefaultTasks();

                  const getTimer = () => {
                     const getCurrentStepTimer = (step) => { //менять время показа каждого слайда

                     switch(step) {
                        case 0:
                           return 26000;
                        case 1:
                           return 26000;
                        case 2:
                        case 3:
                           return 19000;
                        case 4:
                        case 5:
                           return 27000;
                        case 6:
                        case 7:
                           return 32000;
                        case 8:
                        case 9:
                           return 22000;
                        case 10:
                           return 29000;
                        default:
                           return 25000;
                        }
                     };
                     
                     const timerId = setTimeout(() => {
                        currentStepIndex < lastStepIndex ? introJS.nextStep() : introJS.exit();
                     },getCurrentStepTimer(currentStepIndex));
                     
                     setTimeout(() => {
                        const tooltipButtons = document.querySelector('.introjs-tooltip').querySelectorAll('a[role="button"]');
                        
                        for (const button of tooltipButtons) {
                           button.addEventListener('click', () => clearTimeout(timerId));
                        }
                     },0);
                  }

                  const addTaskForPresentation = (step, showHash) => {
                     if (showHash) this.defaultSelected.hash = shownTaskHash;      
                     this.onChangeForPresentation.call(this, shownTaskHash)
                     .then(() => {
                        introJS.goToStepNumber(step)
                     })
                  }

                  switch(currentStepIndex) {
                     case 0:
                        if (document.body.scrollHeight) {
                           window.scrollTo(0, 0);
                           getTimer();
                        };
                     break
                     case 4:
                        if (this.defaultSelected.hash === '#' && shownTaskHash) addTaskForPresentation(currentStepIndex + 1, true);
                        else getTimer();
                     break;
                     case 5:
                        if (this.defaultSelected.hash === '#' && shownTaskHash) addTaskForPresentation(currentStepIndex + 1, true);
                        else getTimer();
                     break;
                     case 6:
                     case 7:
                     case 8:
                        if (!this.items.length) {
                           if ([this.defaultSelected.hash, 
                              this.defaultSelected.taskName, 
                              this.defaultSelected.type, 
                              this.defaultSelected.priority, 
                              this.defaultSelected.time]
                              .every(item => item)) {
                              this.defaultSelected.hash = shownTaskHash;
                              this.addTask();
                              getTimer();
                           } else {
                              if (this.defaultSelected.hash === '#' && shownTaskHash) {
                                 addTaskForPresentation(currentStepIndex + 1, false);
                              }
                              else getTimer();
                           }
                        } else getTimer();
                     break;
                     default:
                        getTimer();
                     break;
                  }
               }).onchange((elem) => {
                  const currentStepIndex = introJS._currentStep;
                  const currentId = elem.id;

                  const configIntroJSObject = (targetElemVal) => {
                     introJS._introItems = [...introJS._introItems.map(item => {
                           if (item.step === 9) return {...item, element: document.getElementById('plan-creating') 
                           ? document.getElementById('plan-creating') 
                           : targetElemVal, 
                           position: 'right'};
                           return item;
                     })];
                  }

                  configIntroJSObject(document.getElementById('plan-creating-wrapper'));
                  
                  setTimeout(() => {
                     if (!introJS._introItems.some(item => item.element === document.getElementById('plan-creating')) && this.items.length && currentId == 'plan-creating-wrapper') {    
                        configIntroJSObject(document.getElementById('plan-creating'));
                        introJS.goToStepNumber(currentStepIndex + 1);
                     }
                  }, 0);
               }).onbeforeexit(() => {
                  this.defaultSelected = {
                  hash: '#',
                  hashCodes: this.defaultSelected.hashCodes,
                  taskName: '',
                  time: '01:00',
                  type: 'required job',
                  priority: '1',
                  details: '',
                  notes: ''
                  };

                  this.items = [];

                  axios.post('/updateEduStep', {
                     newStep: ++currentEduStep,
			         })
               }).start(); 
			}
      } catch(error) {
         console.error(error)
      }
    },

   beforeDestroy() {
      window.removeEventListener('resize', this.updateScreenWidth);
   },
}
</script>
<style scoped>
	.v-progress-circular{
		width: 50px;
		margin: auto;
	}

   .create-day-alert {
      position: relative;
   }

   .create-day-alert_appearance {
      animation: .3s alert_appearance ease;
   }

   .create-day-alert_leave {
      animation: .3s alert_leave ease;
   }

   @keyframes alert_appearance {
		from { opacity: 0; left: -10px;}
		to { opacity: 1; left: 0;}
	}

	@keyframes alert_leave {
		from { opacity: 1; left: 0;}
		to { opacity: 0; left: 10px;}
	}

   @keyframes button_appearance {
		from { opacity: 0; top: -5px;}
		to { opacity: 1; top: 0;}
	}

	@keyframes button_leave {
		from { opacity: 1; top: 0;}
		to { opacity: 0; top: 5px;}
	}

   .button_appearance {
      animation: .25s button_appearance ease;
   }
   
   .button_leave {
      animation: .25s button_leave ease; 
   }

   .tasks-counter-wrapper {
      flex-grow: 1;
      display: flex;
      justify-content: center;
   }

   .tasks-counter {
      margin: 0;
      color: rgba(0,0,0,.6);
   }

   .tasks-counter-enter-active, .tasks-counter-leave-active {
      position: relative;
   }
   .tasks-counter-enter, .tasks-counter-leave-to {
      opacity: 0;
      transform: translateX(-10%); /* Начальное положение при появлении и исчезновении */
   }
   
   .tasks-counter-enter-active, .tasks-counter-leave-active {
      transition: all 0.5s;
   }

   .plan_addTask-button-wrapper_mobile {
      display: none;
   }
   
   @import url('/css/Plan/PlanMedia.css');
</style>