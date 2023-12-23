<template>
    <div>
        <v-data-table 
        :headers="headers" 
        :items="items" 
        class="elevation-1" 
        id="plan-tasks-table">
            <template v-slot:item="props">
                <tr align="center" ref="refWord" @dblclick="deleteItem(props.item)">
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
                                <v-btn 
                                v-bind="attrs" v-on="on"
                                v-on:click="deleteItem(props.item)"
                                color="#D71700" 
                                style="text-color:#ffffff" 
                                icon 
                                >
                                    <v-icon md="1" color="#D71700">
                                        {{ icons.mdiDelete }}
                                    </v-icon>
                                </v-btn>
                            </template>
                            <span>Delete task</span>
                        </v-tooltip>
                    </td>
                </tr>
            </template>
        </v-data-table>
        <v-row>
            <v-col>
                <div 
                id="plan-creating-wrapper" 
                style="min-height: 36px; 
                width: 36px;">
                    <div v-if="items.length > 0">
                        <div class=" d-flex justify-space-between mt-3">
                            <v-tooltip right>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn 
                                    v-bind="attrs" v-on="on"
                                    v-on:click="$emit('formSubmit');" 
                                    id="plan-creating" 
                                    color="#D71700" 
                                    style="text-color:#ffffff" 
                                    icon
                                        >
                                        <v-icon md="1" color="#D71700" large>
                                            {{ icons.mdiClockStart }}
                                        </v-icon>
                                    </v-btn>
                                </template>
                                <span>Create plan</span>
                            </v-tooltip>
                        </div>
                    </div>
                </div>
            </v-col>
            <v-col>
                <v-tooltip right>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn 
                        v-bind="attrs" v-on="on"
                        v-on:click="toggleEmergencyCallDialog" 
                        id="plan-emergency-mode" 
                        color="#D71700" 
                        style="text-color:#ffffff" 
                        icon
                        >
                            <v-icon md="1" color="#D71700" large>
                                {{ icons.mdiCarEmergency }}
                            </v-icon>
                        </v-btn>
                    </template>
                    <span>Emergency mode</span>
                </v-tooltip>
            </v-col>
            <v-alert 
            color="#404040" 
            text 
            class="elevation-1" 
            :value="showAlert" 
            :type="alertType"
            >
                {{ serverMessage }}
            </v-alert>
        </v-row>
        <div 
        v-if="isShowProgress == true"
        class="v-progress-circular" 
        >
            <v-progress-circular :rotate="90" :size="100" :width="5" :value="value" color="red" class="v-progress-circular">
                {{ value }}
            </v-progress-circular>
        </div>
        <!-- <template v-if="isShowEmergencyCallDialog">
            <EmergencyCall v-on:toggleEmergencyCallDialog="toggleEmergencyCallDialog" />
        </template> -->
    </div>
</template>

<script>
import { mdiDelete, mdiClockStart, mdiCarEmergency,} from '@mdi/js'

export default {
    props: {
        items: {
            type: Array,
            required: true,
        },
        showAlert: {
            type: Boolean,
        },
        alertType: {
            type: String,
        },
        serverMessage: {
            type: String,
        },
        isShowProgress: {
            type: Boolean,
        },
        value: {
            type: Number,
        }
    },
    data: () => ({
        icons: { mdiDelete, mdiClockStart,  mdiCarEmergency,},
        isShowEmergencyCallDialog : false,
        headers: [{
                text: '#code',
                value: 'hash',
                align: 'center'
            },
            {
                text: 'Task name',
                align: 'center',
                value: 'taskName',
                groupable: false,
            },
            {
                text: 'Task Type',
                value: 'type',
                align: 'center',
                sort: (taskTypeOne, taskTypeTwo) => {

                   const getPrior = (taskType) => {
                     const typePrior = {
                        'required job':     4,
                        'non required job': 3,
                        'required task':    2,
                        'task':             1,
                     }

                     return typePrior[taskType];
                  }

                  const [taskOnePrior, taskTwoPrior] = ([taskTypeOne, taskTypeTwo].map(item => getPrior(item)));
                  
                  return taskOnePrior - taskTwoPrior;
                },
            },
            {
                text: 'Task Priority',
                value: 'priority',
                align: 'center'
            },
            {
                text: 'Time',
                value: 'time',
                align: 'center'
            },
            {
                text: 'Details',
                value: 'details',
                align: 'center',
            },
            {
                text: 'Notes',
                value: 'notes',
                align: 'center',
            },
            {
                text: 'Action',
                value: '',
                align: 'center',
                sortable: false,
            },
        ],
    }),
    methods: {
        deleteItem(item) {
            this.$emit('deleteItem', item);
        },

        toggleEmergencyCallDialog(){
			this.isShowEmergencyCallDialog = !this.isShowEmergencyCallDialog;
		},
    },
}
</script>