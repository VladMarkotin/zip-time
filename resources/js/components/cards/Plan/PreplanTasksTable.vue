<template>
    <div class="table-max-height-wrapper">
        <v-data-table 
        :headers="headers" 
        :items="items" 
        class="elevation-1" 
        id="plan-tasks-table">
            <template v-slot:body="{ items }">
                <transition-group name="preplanTr" tag="tbody">
                    <tr v-for="(item, index) in items" :key="item.uniqKey" align="center" ref="refWord" @dblclick="deleteItem(item)">
                        <td>{{ item.hash }}</td>
                        <td class="preplan-table-taskName">{{ item.taskName }}</td>
                        <td>{{ item.type }}</td>
                        <td>{{ item.priority }}</td>
                        <td>{{ item.time }}</td>
                        <td>{{ item.details }}</td>
                        <td>{{ item.notes }}</td>
                        <td>
                            <v-tooltip right>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-btn 
                                    v-bind="attrs" v-on="on"
                                    v-on:click="deleteItem(item)"
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
                </transition-group>
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
                sortable: false,
            },
            {
                text: 'Notes',
                value: 'notes',
                align: 'center',
                sortable: false,
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

<style>
.table-max-height-wrapper {
    max-height: 260px;
    overflow-y: auto;
    position: relative; 
}

.table-max-height-wrapper .v-data-footer {
  height: 60px;
  position: sticky;
  bottom: 0;
  background-color: white; 
  z-index: 1; 
}

.preplanTr-enter-active, .preplanTr-leave-active {
  transition: opacity 0.3s;
}
.preplanTr-enter, .preplanTr-leave-to {
  opacity: 0; 
}


#plan-tasks-table .preplan-table-taskName {
    max-width: 130px;
    max-height: 60px;
    overflow: auto;
    word-wrap: break-word; /* Перенос слов, если не помещаются */
}
</style>