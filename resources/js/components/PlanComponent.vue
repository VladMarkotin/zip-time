<template>

    <v-container >


        <v-select
              :items="dayStatuses"
              label="Day status"
              v-model="day_status"
              required
            ></v-select>
            <v-divider></v-divider>

    <div style="    margin-left: auto;
                    margin-right: auto;
                    ">


      <v-row align="center" class="d-flex justify-start mb-6">
        <v-col cols="1" md="1" v-if="defaultSelected.hash == '#'">
            <v-tooltip left>

                    <template v-slot:activator="{ on }">

                             <div class="text-center">
                                <v-dialog
                                  v-model="dialog"
                                  width="500"
                                >
                                  <template  v-slot:activator="{ on, attrs }">
                                    <v-btn icon v-show="showIcon > 3"
                                      color="red lighten-2"
                                      dark
                                      v-bind="attrs"
                                      v-on="on"
                                    >
                                     <v-icon md="1"
                                        color="#D71700"
                                     > {{icons.mdiPlus}}

                                     </v-icon>
                                    </v-btn>
                                  </template>

                                  <v-card>
                                    <v-card-title class="headline grey lighten-2" >
                                      Add #code for this task
                                    </v-card-title>

                                    <v-card-text>
                                      <v-text-field
                                        v-model="newHashCode"
                                        @keypress.enter = "addNewHashCode()"
                                        placeholder="#"></v-text-field>
                                    </v-card-text>

                                    <v-divider></v-divider>

                                    <v-card-actions>
                                      <v-spacer></v-spacer>
                                      <v-btn
                                        color="#D71700"
                                        text
                                        @click = "addNewHashCode()"

                                      >
                                        Add
                                      </v-btn>
                                    </v-card-actions>
                                  </v-card>
                                </v-dialog>
                              </div>
                              </template>
                               <span>Add hash-code to task for quick access</span>
             </v-tooltip>


        </v-col>
        <v-col
          cols="4"
          md="1"
        >
            <v-select
                :items="defaultSelected.hashCodes"
                value="defaultSelected.hashCodes[0]"
                v-model="defaultSelected.hash"
                @change="onChange"
                required>

            </v-select>
        </v-col>
        <v-col cols="4" md="3">
            <v-text-field
                :placeholder=" placeholders[0] "
                :counter="25"
                required
                v-model="defaultSelected.taskName"
                @input="inputChangeHandler"
                @keypress.enter = "addTask"
            ></v-text-field>
            </v-col>
            <v-col cols="1" md="2">
            <v-select
                   :label="placeholders[1]"
                   required
                   :items="taskTypes"
                   v-model="defaultSelected.type"
             ></v-select>
            </v-col>
            <v-col cols="1" md="1">
                <v-select
                                   :label="placeholders[2]"
                                   required
                                   :items="taskPriority"
                                   v-model="defaultSelected.priority"

                ></v-select>
            </v-col>
            <v-col cols="1" md="1">
                <v-text-field
                      v-model="defaultSelected.time"
                      label="Time for task"
                    >00:00</v-text-field>
            </v-col>
            <v-col cols="1" md="1">
                 <v-textarea

                                     outlined
                                     rows="2"
                                     row-height="4"
                                     v-model="defaultSelected.details"
                                     shaped
                           :placeholder="placeholders[4]"
                           :counter="256"
                 ></v-textarea>
             </v-col>
             <v-col cols="1" md="1">
                <v-text-field
                                :placeholder=" placeholders[5] "
                                v-model="defaultSelected.notes"
                                @keypress.enter = "addTask"
                ></v-text-field>
             </v-col>
        <v-col cols="1" md="1">
           <v-tooltip right>
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
      <div>
      <table>
      <tr>
            <div>
                <div style="display:'block';width:800px;margin:auto;">
                    <v-data-table
                        :headers="headers"
                        :items="items"
                        class="elevation-1"
                        @dblclick:tr="deleteItem"
                      >
                        <template v-slot:item="props">
                            <tr align="center"  ref="refWord">
                                <td>{{ props.item.hash }}</td>
                                <td>{{ props.item.taskName }}</td>
                                <td>{{ props.item.type }}</td>
                                <td>{{ props.item.priority }}</td>
                                <td>{{ props.item.time }}</td>
                                <td>{{ props.item.details }}</td>
                                <td>{{ props.item.notes }}</td>
                                <td><v-btn @click="deleteItem(props.item)">Delete task</v-btn></td>
                            </tr>
                        </template>
                </v-data-table>
                
                </div>

            </div>

              <div v-if="items.length > 0">
                    <v-row align="center" class="d-flex justify-start mb-6">
                         <v-btn color="#D71700" style="text-color:#ffffff" icon v-on:click="formSubmit()">
                           <v-icon md="1"
                                   color="#D71700"
                           >
                            {{icons.mdiStarThreePointsOutline}}
                           </v-icon>

                         </v-btn>
                         </v-row >
                         <v-alert
                          :value="showAlert"
                          :type="alertType"
                        >{{serverMessage}}</v-alert>
              </div>
            </tr>
        </table>
      </div>
    </v-container>

</template>
<script>
import Vuetify from 'vuetify/lib'


import {
    mdiAccount,
    mdiPlex,
    mdiPencil,
    mdiShareVariant,
    mdiDelete,
    mdiStarThreePointsOutline,
    mdiAlarm,
    mdiPlus
  } from '@mdi/js'



  export default {
    data: () => ({
      placeholders: ['Enter name of task here', 'Type', 'Priority', 'Time', 'Details', 'Notes'],
      showPlusIcon: 0,
      readyTasks: [],
      newHashCode: '',
      showIcon: 0,
      day_status: 'Work Day',
      defaultSelected: {
        hash: '#',
        hashCodes: [],
        taskName: '',
        time: '00:00',
        type: 'required job',
        priority: '1',
        details: '',
        notes  : ''
      },
      headers: [
               {
                  text: '#code',
                  value: '',
                  align: 'right'
                },
                {
                  text: 'Task name',
                  align: 'start',
                  value: 'task',
                  groupable: false,
                },
                {
                     text: 'Task Type',
                     value: '',
                     align: 'right'
                },
                {
                    text: 'Task Priority',
                    value: '',
                    align: 'right'
                },
                {
                   text: 'Time',
                   value: '',
                   align: 'right'
                },
                {
                   text: 'Details',
                   value: '',
                   align: 'right'
                },
                {
                   text: 'Notes',
                   value: '',
                   align: 'right'
                },
                {
                     text: 'Action',
                     value: '',
                     align: 'center'
                },
       ],
       items: [],
      icons: {
                    mdiAccount,
                    mdiPlex,
                    mdiDelete,
                    mdiPencil,
                    mdiStarThreePointsOutline,
                    mdiAlarm,
                    mdiPlus,
            },
      hashCodes: [],
      hashNames: '#',
      taskTypes: ['required job','non required job','required task', 'task', 'reminder'],
      taskPriority: ['1', '2', '3'],
      dayStatuses: ['Work Day', 'Weekend', 'Holiday', 'Emergency'],
      time: '',
      notes: '',
      details: '',
      serverMessage: '',
      showAlert: false,
      alertType: 'success',
      dialog: false,
      dialogDelete: false,
    }),
    methods: {
        getPostParams(){
            return JSON.stringify({
                date: new Date().toISOString().substr(0,10),
                day_status: this.dayStatuses.indexOf(this.day_status),
                plan: this.items
             })
        },
        inputChangeHandler(){
            if(this.showIcon < 4){
                this.showIcon += 1
            }

        },

         onChange(event) {

             let currentObj = this;
             axios.post('/getSavedTask', {hash_code: event})
                  .then(function (response) {
                        currentObj.defaultSelected.taskName = response.data[0];
                        currentObj.defaultSelected.type = ['required job','non required job','required task', 'task', 'reminder'].reverse()[response.data[1]];
                        currentObj.defaultSelected.priority = `${response.data[2]}`;
                        currentObj.defaultSelected.time = response.data[4];
                        currentObj.defaultSelected.details = response.data[3];
                        currentObj.defaultSelected.notes = response.data[5];
                  })
                  .catch(function (error) {
                      currentObj.output = error;
                  });

         },

        addTask(e) {
            /*мне нужно каждому полю из моего стартового меню присвоить модель и запихнуть значение в taskName
            * тогда я получу json-объект для отправки на серсер
            */
            this.items.push(this.defaultSelected);
            /*check*/
            /*end*/
            this.showIcon   = 0;
            this.defaultSelected = {
                    hashCodes : this.defaultSelected.hashCodes,
                    hash: '#',
                    taskName: '',
                    time: '00:00',
                    type: 'required job',
                    priority: '1',
                    details: '',
                    notes  : ''
                  }
        },
        deleteItem (item) {
            var index = this.items.indexOf(item)
            this.items.splice(index, 1);
        },

        addNewHashCode(){
            if( (this.newHashCode.length <= 6) && (this.newHashCode.length >= 3) ){
                  if(this.newHashCode.indexOf('#') !== -1){
                        this.addNewHashCodePost();
                        this.defaultSelected.hashCodes.unshift(this.newHashCode);
                        this.dialog = false;
                  }else{
                       this.newHashCode = '#' +  this.newHashCode
                  }
            }
        },

        formSubmit(e) {
             let currentObj = this;
             axios.post('/addPlan',this.getPostParams())
                 .then(function (response) {
                    currentObj.alertType = response.status;
                    currentObj.serverMessage = response.message;
                    currentObj.showAlert = true;
                    setTimeout(() => currentObj.showAlert = false,5e3)
                 })
                 .catch(function (error) {
                     currentObj.output = error;
                 });
        },

        addNewHashCodePost(){
            let currentObj = this;
            axios.post('/addHashCode',{
               'hash': this.newHashCode,
               'taskName': this.defaultSelected.taskName,
               'time' : this.defaultSelected.time,
               'type' : this.defaultSelected.type,
               'priority' : this.defaultSelected.priority,
               'details' : this.defaultSelected.details,
               'notes' : this.defaultSelected.notes,
              })
               .then(function (response) {
            })
            .catch(function (error) {
                currentObj.output = error;
            });
        },
    },
    created() {
         let currentObj = this;
         axios.post('/getSavedTasks')
              .then(function (response) {
                    currentObj.defaultSelected.hashCodes = response.data.hash_codes;
                    let length = response.data.hash_codes.length;
                    for (let i = 0; i < length; i++){
                        currentObj.defaultSelected.hashCodes[i] = currentObj.defaultSelected.hashCodes[i].hash_code
                    }
              })
              .catch(function (error) {
                   currentObj.output = error;
              });
    },
    watch:{
        taskName: function (){
             //++this.showIcon;
        }
    }


  }
</script>