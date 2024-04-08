<template>
    <div id="plan-tasks-table">
        <transition name="fade">
            <div class="table-max-height-wrapper" v-if="!isShowPreloader" >
                <v-data-table 
                :headers             = "headers" 
                :items               = "items" 
                class                = "elevation-1" 
                :dense               = "isMobile"  
                :hide-default-footer = "isMobile" 
                >
                    <template v-slot:body="{ items }">
                        <tbody  v-if="!items || items.length === 0" >
                            <tr>
                                <td :colspan="headers.length" class="text-center body-1">Your day plan is still empty</td>
                            </tr>
                        </tbody>
                        <transition-group name="preplanTr" tag="tbody" v-else >
                            <tr 
                            v-for="(item) in items" 
                            :key="item.uniqKey" 
                            align="center" 
                            ref="refWord" 
                            @dblclick="deleteItem(item)">
                                <td>{{ item.hash }}</td>
                                <td class="preplan-table-taskName">{{ item.taskName }}</td>
                                <td>{{ item.type }}</td>
                                <td>{{ item.priority }}</td>
                                <td>{{ item.time }}</td>
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
        </transition>
        <transition name="fade">
            <div
            v-if="isShowPreloader"
            class="table-preloader-wrapper"
            >
                <DefaultPreloader 
                :size="80"
                :width="7"
                />
            </div>
        </transition>
    </div>
</template>

<script>
import { mdiDelete, } from '@mdi/js'
import DefaultPreloader from '../../UI/DefaultPreloader.vue'
export default {
    props: {
        items: {
            type: Array,
            required: true,
        },
        isShowPreloader: {
            type: Boolean,
            default: false,
        },
        screenWidth: {
            type: Number,
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
    computed: {
        isMobile() {
            return this.screenWidth < 450;
        }
    },
    components: { DefaultPreloader},
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

.table-max-height-wrapper::-webkit-scrollbar {
  width: 15px;
}

.table-max-height-wrapper::-webkit-scrollbar-track {
  background: #e6e6e6;
  border-left: 1px solid #dadada;
}

.table-max-height-wrapper::-webkit-scrollbar-thumb {
  background: #b0b0b0;
  border: solid 3px #e6e6e6;
  border-radius: 7px;
}

.table-max-height-wrapper::-webkit-scrollbar-thumb:hover {
  background: rgb(161, 0, 0);;
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
    width: 250px;
    max-width: 300px;
    max-height: 60px;
    overflow: auto;
    word-wrap: break-word; /* Перенос слов, если не помещаются */
}

.table-preloader-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
}

.fade-enter-active {
   transition: opacity .3s, transform .3s;
}

.fade-enter,
.fade-leave-active {
  opacity: 0;
   transform: translateY(-5%); 
}
</style>