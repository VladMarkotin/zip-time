<template>
   <v-card id="plan-wrapper">
      <template v-if="isShowAddHashCodeDialog">    
         <AddHashCode
         :width          = "450"
         :hashCodeVal    = "newHashCode"
         :isShowDialog   = "isShowAddHashCodeDialog"
         :taskName       = "defaultSelected.taskName"
         :time           = "defaultSelected.time"
         :type           = "defaultSelected.type"
         :priority       = "defaultSelected.priority"
         :details        = "defaultSelected.details"
         :notes          = "defaultSelected.notes"
         @close          = "closeHashCodeDialog"
         @changeHashCode = "changeHashCode"
         @addHashCode    = "addHashCode"
         />
      </template>
      <v-card-title style="background-color: #A10000;color: white;" >Create your day plan!</v-card-title>
      <v-container>
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
         <v-divider></v-divider>
         <div>
            <v-row align="center" class="d-flex justify-content-between" >
               <v-col
                  md="3"
                  >
                  <v-row class="p-0 m-0 d-flex justify-content-between"> 
                     <v-col
                     md="3" 
                     class="p-0 m-0 d-flex justify-content-center align-items-center"
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
                           @change="onChange"
                           required>
                        </v-select>
                     </v-col>    
                     <v-col md="3" class="p-0 m-0 d-flex justify-content-center align-items-center">
                        <CleanHashCodeButton 
                        v-if="defaultSelected.hash.length > 1"
                        :tooltipPosition = "{bottom: true}"
                        :tooltipText     = "'Clear'"
                        @clearCurrentHashCode="clearCurrentHashCode"
                        />
                     </v-col>
                  </v-row>
               </v-col>
               <v-col md="3">
                  <v-text-field
                     :placeholder=" placeholders[0] "
                     :counter="25"
                     required
                     v-model="defaultSelected.taskName"
                     @input="inputChangeHandler"
                     @keypress.enter = "addTask"
                     ></v-text-field>
               </v-col>
               <v-col md="2">
                  <v-select
                     :label="placeholders[1]"
                     required
                     :items="taskTypes"
                     v-model="defaultSelected.type"
                     >
                     <template v-slot:item="{item}" >
                           <v-list-item >{{ item }}</v-list-item>
                           <!-- open-on-hover -->
                           <VSelectTooptip 
                           :item="item"
                           :tooltipData = "tooltipTypesData"
                           />
                     </template>
                  </v-select>
               </v-col>
               <v-col md="1">
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
               cols="1" 
               md="1">
                  <v-menu ref="v-menu" v-bind:close-on-content-click="false" v-model="menu">
                     <template v-slot:activator="{on}">
                        <v-text-field label="Time" prepend-icon="mdi-clock-time-four-outline" readonly v-model="defaultSelected.time" v-on="on"></v-text-field>
                     </template>
                     <v-time-picker
                        color="#D71700"
                        v-on:click:minute="$refs['v-menu'].save(defaultSelected.time)"
                        v-model="defaultSelected.time">
                     </v-time-picker>
                  </v-menu>
               </v-col>
            
               <v-col md="1">
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
         </div>
         <v-divider></v-divider>
         <PreplanTasksTable 
         :items          = "items"
         @deleteItem  = "deleteItem"
         />
         <v-row 
         class="d-flex justify-content-between align-items-center"
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
               v-if="items.length > 0"
               >
                  <v-tooltip right>
                     <template v-slot:activator="{ on, attrs }">
                        <v-btn 
                        id="plan-creating" 
                        v-on:click="formSubmit()" 
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
                  class="elevation-1 create-day-alert mb-0 d-flex justify-content-center align-items-center" 
                  :type="alertType"
                  >
                     {{serverMessage}}
                  </v-alert>
            </transition>
         </v-col>
         <v-col 
         class="d-flex justify-content-end align-items-center"
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
         
         <template v-if="isShowEmergencyCallDialog">
	         <EmergencyCall  v-on:toggleEmergencyCallDialog="toggleEmergencyCallDialog"/>
         </template>
      </v-container>
   </v-card>
</template>
<script>
import AddHashCode from '../../dialogs/AddHashCode.vue';
import AddHashCodeButton from '../../UI/AddHashCodeButton.vue';
import CleanHashCodeButton from '../../UI/CleanHashCodeButton.vue';
import Vuetify from 'vuetify/lib'
import EmergencyCall from '../../dialogs/EmergencyCall.vue';
import PreplanTasksTable from './PreplanTasksTable.vue';
import VSelectTooptip from '../../UI/VSelectTooptip.vue';
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

export default {
   components : {EmergencyCall, AddHashCode, AddHashCodeButton, CleanHashCodeButton, PreplanTasksTable, VSelectTooptip},
    data: () => ({
        placeholders: ['Enter name of task here', 'Type', 'Priority', 'Time', 'Details', 'Notes'],
        showPlusIcon: 0,
        readyTasks: [],
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
        preparedTask: {},
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
        hashNames: '#',
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
        time: '',
        notes: '',
        details: '',
        serverMessage: '',
        showAlert: false,
        alertType: 'success',
        isShowAddHashCodeDialog: false,
        dialogDelete: false,
        isShowProgress: false,
        value: 0,
        interval: {},
        closeAlertTime: 0,
    }),
    computed : {
        taskTypes() {
            return this.
               day_status == 'Weekend' ? ['non required job', 'task', 'reminder'] : ['required job', 'non required job', 'required task', 'task']
        },

        tooltipTypesData() {
            return {
               titles: {
                  requiredJob: 'required job',
                  nonRequiredJob: 'non required job',
                  requiredTask: 'required task',
                  task: 'task',
               },
               descriptions: {
                  requiredJob: `<span style="text-indent: -1em; padding-left: 1em;">Main entity of your plan. By adding a required job, you kind of sign a commitment with yourself that you will at least start doing it today. After finishing working on a job, you should evaluate the effort you spent.</span><br><span style="text-indent: -1em; padding-left: 1em;">By 23:59 all (!) required jobs should be evaluated</span>`,
                  nonRequiredJob: `<span style="text-indent: -1em; padding-left: 1em;">Some of your day\`s jobs could be not so important but, anyway, you want to evaluate your efforts. So, non required jobs are exactly what you need. Failure to comply has no consequences. Moreover, to complete all non required jobs is a perfect way to increase your final day grade</span>`,
                  requiredTask: `<span style="text-indent: -1em; padding-left: 1em;">We often have a plenty of small (but important) tasks (e.g “call to the boss”). It would be difficult to evaluate the result of such task, but, anyway, you have to do it.</span>`,
                  task: `<span style="text-indent: -1em; padding-left: 1em;">Anything that\`s not so important and hard to evaluate but necessary personally for you ( e.g. “night out with friends” )</span>`,
               },
            }
        },

        tooltipPrioritiesData() {
            return {
               titles: {
                  '1' : 'usual',
                  '2' : 'important',
                  '3' : 'extremly imortant',
               }
            }
        }
    },
    methods: {

      clearCurrentHashCode(){
					this.defaultSelected.hash = '#'
					this.defaultSelected.taskName = ''
					this.defaultSelected.type = 'required job'
					this.defaultSelected.priority = '1'
					this.defaultSelected.time = '01:00'
		},
       
        getPostParams() {
            // return {
            //    date: new Date().toISOString().substr(0, 10),
            //    day_status: {Weekend: 1, 'Work Day': 2}[this.day_status],
            //    plan: this.items,
            // };  //было так, но есть ошибка при добавлении в план на день хоть одной дефолтной таски

            return {
                date: new Date().toISOString().substr(0, 10),
                day_status: {Weekend: 1, 'Work Day': 2}[this.day_status],
                plan: [...this.items.map(item => {
                        if (item.hash.match(/^#q-/)) return {...item, hash: '#'};
                        return item;
                     })]
            }; //тут костыль
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
            axios.post('/isWeekendAvailable', {
                    //hash_code: event
            })
            .then(function(response) {
                  currentObj.dayStatuses2[1].disable = response.data.isWeekendAvailable
             })
            .catch(function(error) {
                    currentObj.output = error;
            });

        },

        onChange(event) {
            let currentObj = this;

            axios.post('/getSavedTask', {
                  hash_code: event
               })
               .then(function(response) {
                  currentObj.defaultSelected.taskName = response.data[1];
                  currentObj.defaultSelected.type = response.data[2];
                  console.log(response.data[2])
                  currentObj.defaultSelected.priority = `${response.data[3]}`;
                  currentObj.defaultSelected.time = response.data[5];
                  currentObj.defaultSelected.details = response.data[4];
                  currentObj.defaultSelected.notes = response.data[6];
                })
                .catch(function(error) {
                    currentObj.output = error;
                });
           
        },

         onChangeForPresentation(event) {
            const currentObj = this;

            return new Promise((resolve, reject) => {
               axios.post('/getSavedTask', {
                  hash_code: event
               })
               .then(function(response) {
                  currentObj.defaultSelected.taskName = response.data[1];
                  currentObj.defaultSelected.type = response.data[2];
                  currentObj.defaultSelected.priority = `${response.data[3]}`;
                  currentObj.defaultSelected.time = response.data[5];
                  currentObj.defaultSelected.details = response.data[4];
                  currentObj.defaultSelected.notes = response.data[6];
                  resolve();
                })
                .catch(function(error) {
                    currentObj.output = error;
                });
            });
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

        setAlert({serverMessage, alertType}) {
         //если длина названия таски очень большая, то оставляю первые 25 символов только
         const regex = /The task (.+?) has/g;
         const matches = regex.exec(serverMessage);
         if (matches) {
            const taskName = matches[1]; 
            
            if (taskName && taskName.length > 25) {
               serverMessage = serverMessage.replace(taskName, taskName.slice(0,25) + '...');
            }
         }

            this.serverMessage = serverMessage;
            this.alertType = alertType;
            this.showAlert = true;

            clearTimeout(this.closeAlertTime);
            this.closeAlertTime = setTimeout(() => {
               this.showAlert = false;
            }, 3000);
        },

        addTask() {
         
         this.showAlert = false;
         const checkTaskResult = this.checkDefaultSelected();
         const {taskName}      = this.defaultSelected;

         if (checkTaskResult !== true) {
            this.setAlert({serverMessage: checkTaskResult, alertType: 'error'});
            return;
         }

         this.items.push({...this.defaultSelected, uniqKey: uuid.v1()});
         this.showIcon = 0;
         this.defaultSelected = {
                hashCodes: this.defaultSelected.hashCodes,
                hash: '#',
                taskName: '',
                time: '00:00',
                type: this.day_status == 'Weekend' ? 'non required job' : 'required job',
                priority: '1',
                details: '',
                notes: ''
            }
            // если показываю алерт через метод setAlert и использую название таски, то важно для регулярки что бы текст был вида
            // The task .... has  (влияет на работу регулярки и обрезание большого названия таски)
         this.setAlert({serverMessage: `The task ${taskName} has been successfully added`, alertType: 'success'});
        },

        deleteItem(item) {
            const index = this.items.indexOf(item)
            const {taskName} = this.items[index];

            this.items.splice(index, 1);
             // если показываю алерт через метод setAlert и использую название таски, то важно для регулярки что бы текст был вида
            // The task .... has  (влияет на работу регулярки и обрезание большого названия таски)
            this.setAlert({serverMessage: `The task ${taskName} has been successfully removed`, alertType: 'success'});
        },

        formSubmit(e) {
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
                         if (response.data.status == 'success') {
                            const data = JSON.parse(response.config.data)
                            currentObj.$root.currComponentProps = data.plan
                            currentObj.$root.currComponent = "ReadyDayPlan"
                            
                         }
                     }, 5e3)
                  }  
                  
                  if (status === 'error') {
                     clearTimeout(currentObj.closeAlertTime);

                     currentObj.closeAlertTime = setTimeout(() => {
                        currentObj.showAlert = false;
                     }, 3000);

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
      },
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

         axios.post('/getEduStep', {
                    //hash_code: event
         })
         .then(function(response) {
                  console.log(response)
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

         axios.post('/getPreparedPlan')
         .then(function(response) {
            if(response){
               for(let i = 0; i < response.data.length; i++){
                  for(let j = 0; j < response.data[i].length; j++){
                     currentObj.preparedTask.hash = response.data[i][0].hash_code;
                     currentObj.preparedTask.taskName = response.data[i][0].task_name;
                     currentObj.preparedTask.type = response.data[i][0].type;//['required job', 'non required job', 'required task', 'task', 'reminder'].reverse()[response.data[0].type]
                     currentObj.preparedTask.priority = `${response.data[i][0].priority}`;
                     currentObj.preparedTask.time = response.data[i][0].time;
                     currentObj.preparedTask.details = response.data[i][0].details;
                     currentObj.preparedTask.notes = response.data[i][0].note;
                     
                     currentObj.items.push(currentObj.preparedTask);
                     currentObj.preparedTask = {};
                  }
               }
            }
         })
         .catch(function(error) {
            currentObj.output = error;
         });
    },

    async mounted() {
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
</style>