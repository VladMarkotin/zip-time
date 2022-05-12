<template>
   <v-card>
      <v-card-title style="background-color: #A10000;color: white;">Create your day plan!</v-card-title>
      <v-container>
         <v-select
            :items="dayStatuses"
            label="Day status"
            v-model="day_status"
            required
            ></v-select>
         <v-divider></v-divider>
         <div>
            <v-row align="center" class="d-flex mb-6">
               <v-col cols="1" md="1" v-if="defaultSelected.hash == '#'">
                  <div class="text-center">
                     <v-dialog max-width="650px" persistent v-model="dialog">
                        <template #activator="{ on: dialog }">
                           <v-tooltip right>
                              <template v-slot:activator="{ on:tooltip  }">
                                 <v-btn icon v-on="{ ...tooltip, ...dialog }" v-show="showIcon > 3">
                                    <v-icon md="1"
                                       color="#D71700"
                                       > {{icons.mdiPlusBox}}
                                    </v-icon>
                                 </v-btn>
                              </template>
                              <span>Add hash-code to task for quick access</span>
                           </v-tooltip>
                           
                        </template>
		<v-card>
			<v-card-title class="font-weight-bold v-card-title">Add #code</v-card-title>
			<v-card-text>
				<v-text-field label="#code" required v-model="newHashCode"></v-text-field>
			</v-card-text>
			<v-divider></v-divider>
			<v-card-actions class="justify-space-between v-card-actions">
				<v-tooltip right>
					<template v-slot:activator="{on}">
						<v-btn icon v-on="on" v-on:click="addHashCode">
							<v-icon color="#D71700" large>{{icons.mdiPlusBox}}</v-icon>
						</v-btn>
					</template>
					<span>Add #code</span>
				</v-tooltip>
            <v-tooltip right>
					<template v-slot:activator="{on}">
						<v-btn icon v-on="on" v-on:click="cleanHashCode">
							<v-icon color="#D71700" large>{{icons.mdiCancel}}</v-icon>
						</v-btn>
					</template>
					<span>Cancel</span>
				</v-tooltip>
			</v-card-actions>
		</v-card>
	</v-dialog>
                  </div>
               </v-col>
               <v-col
                  cols="3"
                  md="2"
                  :offset="defaultSelected.hash == '#' ? 0 : 1"
                  :offset-md="defaultSelected.hash == '#' ? 0 : 1"
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
               <v-col cols="1" md="3">
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
            <!-- </v-row> -->
            <!-- <v-row> -->
               <!-- <v-col cols="5" md="5" offset="1" offset-md="1">
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
               <v-col cols="5" md="5">
                  <v-text-field
                     :placeholder=" placeholders[5] "
                     v-model="defaultSelected.notes"
                     @keypress.enter = "addTask"
                     ></v-text-field>
               </v-col> -->
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
                  <td>
                     <v-tooltip right>
                        <template v-slot:activator="{ on, attrs }">
                           <v-btn color="#D71700" style="text-color:#ffffff" icon v-on:click="deleteItem(props.item)" v-bind="attrs"
                              v-on="on">
                              <v-icon md="1"
                                 color="#D71700"
                                 >
                                 {{icons.mdiDelete}}
                              </v-icon>
                           </v-btn>
                        </template>
                        <span>Delete task</span>
                     </v-tooltip>
                  </td>
               </tr>
            </template>
         </v-data-table>
         <div v-if="items.length > 0">
            <div class=" d-flex justify-space-between mt-3">
               <v-tooltip right>
                  <template v-slot:activator="{ on, attrs }">
                     <v-btn color="#D71700" style="text-color:#ffffff" icon v-on:click="formSubmit()" v-bind="attrs"
                        v-on="on">
                        <v-icon md="1"
                           color="#D71700"
                           large
                           >
                           {{icons.mdiStarThreePointsOutline}}
                        </v-icon>
                     </v-btn>
                  </template>
                  <span>Create plan</span>
               </v-tooltip>
               <v-tooltip right>
                  <template v-slot:activator="{ on, attrs }">
                     <v-btn color="#D71700" style="text-color:#ffffff" icon v-on:click="" v-bind="attrs"
                        v-on="on">
                        <v-icon md="1"
                           color="#D71700"
                           large
                           >
                           {{icons.mdiCarEmergency}}
                        </v-icon>
                     </v-btn>
                  </template>
                  <span>Emergency call</span>
               </v-tooltip>
            </div>
         </div>
         <v-alert
            color="#404040"
            text
            class="elevation-1"
            :value="showAlert"
            :type="alertType"
            >{{serverMessage}}</v-alert>
      </v-container>
   </v-card>
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
    mdiCarEmergency,
    mdiPlus,
    mdiPlusBox,
    mdiCancel
} from '@mdi/js'

export default {
    data: () => ({
        placeholders: ['Enter name of task here', 'Type', 'Priority', 'Time', 'Details', 'Notes'],
        showPlusIcon: 0,
        readyTasks: [],
        newHashCode: '',
        showIcon: 0,
        day_status: 'Work Day',
        menu: false/*for defaultSelected.time*/,
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
        headers: [{
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
            mdiPlusBox,
            mdiCancel,
            mdiCarEmergency,
        },
        hashCodes: [],
        hashNames: '#',
        taskPriority: ['1', '2', '3'],
        dayStatuses: ['Work Day', 'Weekend'],
        time: '',
        notes: '',
        details: '',
        serverMessage: '',
        showAlert: false,
        alertType: 'success',
        dialog: false,
        dialogDelete: false,
    }),
    computed : {
        taskTypes() {
            return this.
               day_status == 'Weekend' ? ['non required job', 'task', 'reminder'] : ['required job', 'non required job', 'required task', 'task', 'reminder']
        }
    },
    methods: {
        getPostParams() {
            return JSON.stringify({
                date: new Date().toISOString().substr(0, 10),
                day_status: this.dayStatuses.indexOf(this.day_status),
                plan: this.items
            })
        },
        inputChangeHandler() {
            if (this.showIcon < 4) {
                this.showIcon += 1
            }

        },

        onChange(event) {
            let currentObj = this;
            axios.post('/getSavedTask', {
                    hash_code: event
                })
                .then(function(response) {
                    currentObj.defaultSelected.taskName = response.data[0];
                    currentObj.defaultSelected.type = ['required job', 'non required job', 'required task', 'task', 'reminder'].reverse()[response.data[1]];
                    currentObj.defaultSelected.priority = `${response.data[2]}`;
                    currentObj.defaultSelected.time = response.data[4];
                    currentObj.defaultSelected.details = response.data[3];
                    currentObj.defaultSelected.notes = response.data[5];
                })
                .catch(function(error) {
                    currentObj.output = error;
                });

        },

        addTask(e) {
            this.items.push(this.defaultSelected);
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
        },
        deleteItem(item) {
            var index = this.items.indexOf(item)
            this.items.splice(index, 1);
        },

        addHashCode()
				{
               debugger
					if (this.newHashCode.length >= 3 && this.newHashCode.length <= 6)
					{
						if (this.newHashCode.includes('#'))
						{
							this.addNewHashCodePost();
							this.defaultSelected.hashCodes.unshift(this.newHashCode);
                     this.dialog = false;
						}
						else
						{
							this.newHashCode = `#${this.newHashCode}`
						}
					}
				},
         cleanHashCode()
				{
               this.newHashCode = ``
					this.dialog = false;
				},

        formSubmit(e) {
            let currentObj = this;

            axios.post('/addPlan', currentObj.getPostParams())
                .then(function(response) {
                    currentObj.alertType = response.data.status;
                    currentObj.serverMessage = response.data.message;
                    currentObj.showAlert = true;
                    setTimeout(() => {
                        currentObj.showAlert = false
                        if (response.data.status == 'success') {
                           const data = JSON.parse(response.config.data)
                           currentObj.$root.currComponentProps = data.plan
                           currentObj.$root.currComponent = "ReadyDayPlan"
                        }
                    }, 5e3)
                })
                .catch(function(error) {
                    currentObj.output = error;
                });
        },

        addNewHashCodePost() {
            let currentObj = this;
            axios.post('/addHashCode', {
                    'hash': this.newHashCode,
                    'taskName': this.defaultSelected.taskName,
                    'time': this.defaultSelected.time,
                    'type': this.defaultSelected.type,
                    'priority': this.defaultSelected.priority,
                    'details': this.defaultSelected.details,
                    'notes': this.defaultSelected.notes,
                })
                .then(function(response) {})
                .catch(function(error) {
                    currentObj.output = error;
                });
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
            })
            .catch(function(error) {
                currentObj.output = error;
            });
    }

}
</script>