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
    </div>
</template>

<script>
import { mdiDelete, } from '@mdi/js'

export default {
    props: {
        items: {
            type: Array,
            required: true,
        },
    },
    data: () => ({
        icons: { mdiDelete,},
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
    },
}
</script>