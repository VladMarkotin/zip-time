<template>

    <v-container >


    <v-tooltip left>
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              color="primary"
              dark
              v-bind="attrs"
              v-on="on"
            >
              Left
            </v-btn>
          </template>
          <span>Left tooltip</span>
        </v-tooltip>


        <v-select
              :items="dayStatuses"
              label="Day status"
              v-model="defaultSelected.value"
              required
            ></v-select>
            <v-divider></v-divider>

    <div style="    margin-left: auto;
                    margin-right: auto;
                    ">


      <v-row align="center" class="d-flex justify-start mb-6">
        <v-col cols="1" md="1" v-if="defaultSelected.hash == '#'">
        <v-tooltip left>
                <template v-slot:activator="{ on, attrs }">
                    <v-btn icon >
                               <v-icon md="1"
                                    color="#D71700"
                                    v-on:click="addTask"> {{icons.mdiPlus}}

                                </v-icon>
                    </v-btn>
                 </template>
                           <span>Left tooltip</span>
         </v-tooltip>


        </v-col>
        <v-col
          cols="4"
          md="1"
        >
            <v-select
                :items="defaultSelected.hashCodes"
                :value="defaultSelected.hashCodes[0]"
                v-model="defaultSelected.hash"
                required>

            </v-select>
        </v-col>
        <v-col cols="4" md="3">
            <v-text-field
                :placeholder=" placeholders[0] "
                :counter="25"
                required
                v-model="inputValue"
                @input="inputChangeHandler"
                @keypress.enter = "addTask"
            ></v-text-field>
            </v-col>
            <v-col cols="1" md="2">
            <v-select
                   :label="placeholders[1]"
                   required
                   :items="taskTypes"
                   v-model="defaultSelected.defaultTaskType"
             ></v-select>
            </v-col>
            <v-col cols="1" md="1">
                <v-select
                                   :label="placeholders[2]"
                                   required
                                   :items="taskPriority"
                                   v-model="defaultSelected.defaultPriority"

                ></v-select>
            </v-col>
            <v-col cols="1" md="1">
                <v-text-field
                      v-model="defaultSelected.time"
                      label="Time for task"
                    >{{icons.mdiAlarm}}</v-text-field>
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
                                required
                                v-model = "defaultSelected.notes"
                                @keypress.enter = "addTask"
                ></v-text-field>
             </v-col>
        <v-col cols="1" md="1">
            <v-btn icon>
                       <v-icon md="1"
                            color="#D71700"
                            v-on:click="addTask"> {{icons.mdiPlex}}
                        </v-icon>
            </v-btn>
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
                        :items="readyTasks"
                        item-key="task"
                        class="elevation-1"
                        @dblclick:row="deleteItem"
                      >

                </v-data-table>

                </div>

            </div>

              <div v-if="tasks.length > 1">
                    <v-row align="center" class="d-flex justify-start mb-6">
                         <v-btn color="#D71700" style="text-color:#ffffff" icon v-on:click="formSubmit()">
                           <v-icon md="1"
                                   color="#D71700"
                           >
                            {{icons.mdiStarThreePointsOutline}}
                           </v-icon>

                         </v-btn>
                         </v-row >
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
      inputValue: '',
      taskName: {},
      readyTasks: [],
      defaultSelected: {
        value: 'Work Day',
        hash: '#',
        hashCodes: ['#', '#one'],
        inputValue: '',
        time: '00:00',
        defaultTaskType: 'required job',
        defaultPriority: '1',
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
       ],

       icons: {

                     mdiPlex,
                     mdiPencil,
                     mdiShareVariant,
                     mdiDelete,
             },
      icons: {
                    mdiAccount,
                    mdiPlex,
                    mdiDelete,
                    mdiPencil,
                    mdiStarThreePointsOutline,
                    mdiAlarm,
                    mdiPlus,
            },
      hash: ['#', '#One'],
      hashNames: '#',
      taskTypes: ['required job','non required job','required task', 'task', 'reminder'],
      taskPriority: ['1', '2', '3'],
      dayStatuses: ['Work Day', 'Weekend', 'Holiday', 'Emergency'],
      time: '00:00',
      note: '',
      tasks: [],
      taskObject: {name: '', type: '', priority: '', time: '', details: '', notes: ''},
      dialogDelete: false,
    }),
    methods: {
        inputChangeHandler(){

        },
        addTask(value) {
            this.taskObject.name = this.inputValue;
            this.taskName.hash = "#test";
            this.taskName.task = this.inputValue ;
            this.defaultSelected.inputValue = this.inputValue ;
            this.defaultSelected.time = this.time
            //this.defaultSelected.notes = this.note
            /*мне нужно каждому полю из моего стартового меню присвоить модель и запихнуть значение в taskName
            * тогда я получу json-объект для отправки на серсер
            */
            this.tasks.push(this.defaultSelected);
            /*check*/
                console.log(this.tasks);
            /*end*/
            this.inputValue = '';
            this.taskName = {}
            this.defaultSelected = {
                    value: 'Work Day',
                    hash: '#',
                    hashCodes: ['#', '#one'],
                    inputValue: '',
                    time: '',
                    defaultTaskType: 'required job',
                    defaultPriority: '1',
                    details: '',
                    notes  : ''
                  }
        },
        deleteItem (item) {
            var index = this.tasks.indexOf(item)
            this.tasks.splice(index, 1);
            console.log(index);
        },

        formSubmit(e) {
             //e.preventDefault();
             let currentObj = this;
             axios.post('/addPlan',this.defaultSelected)
                 .then(function (response) {
                     console.log(response);
                 })
                 .catch(function (error) {
                     currentObj.output = error;
                 });
        }
    }
  }
</script>