<template>
    <v-dialog 
    :fullscreen = "isMobile"
    v-model="isShowEditCardDataDialog" 
    persistent 
    scrollable
    width="500">
        <template v-slot:activator="{ props }">
            <template>
                <EditButton @click="isShowEditCardDataDialog = true" />
            </template>
        </template>
        <v-card class="pt-6 pb-6 editCardData_editCard-wrapper d-flex flex-column">
            <v-card-text class="pb-2 pt-2 editCardData-content">
                <v-row class="p-0 m-0" v-if="!isTodayAWeekend">
                    <h4 class="p-0" style="font-size: 1rem;">Edit task`s type:</h4>
                    <SelectTaskType 
                    label      = "Type" 
                    v-model    = "selectedType"
                    :taskTypes = "types"
                    :solo      = "true"
                    />
                </v-row>
                <v-row class="p-0 m-0">
                    <h4 class="p-0" style="font-size: 1rem;">Edit task`s priority:</h4>
                    <v-select
                        :items="priorities"
                        v-model="selectedPriority"
                        label="Set Priority"
                        solo
                    >
                    <template v-slot:item="{item}" >
                           <v-list-item >{{ item }}</v-list-item>
                           <VSelectTooptip 
                           :item              = "String(item)"
                           :width             = "200"
						   :tooltipData       = "tooltipPrioritiesData"
						   :isShowDescription = "false"
                           />
                        </template>
                </v-select>
                </v-row>
                <v-row class="p-0 m-0">
                    <h4 class="p-0" style="font-size: 1rem;">Edit task`s time:</h4>
                    <v-time-picker 
                    class="editCardData-time-picker p-0 pb-3"
                    ref="picker"
                    v-model="selectedTime"
                    color="#D71700"
                    :format="timeFormat"
                    @click:hour="selectinghourifusehoursonly"
                    > 
                    </v-time-picker>
                    <div class="p-0 m-0 d-flex justify-content-center align-items-center">
                        <v-btn 
                        @click="toggleTimeFormat">
                        Toggle Time Format
                        </v-btn>
                    </div>
                </v-row>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions class="px-5 pb-0 editCardData-footer">
                <div class="d-flex justify-content-between" style="width: 100%;">
                    <v-btn
                        color="green-darken-1"
                        variant="text"
                        @click="saveChanges"
                    >
                        Save
                    </v-btn>
    
                    <v-btn
                        color="green-darken-1"
                        variant="text"
                        @click="cancelChanges"
                    >
                        Cancel
                    </v-btn>
                </div>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import store from '../../store';
import { mapGetters } from 'vuex/dist/vuex.common.js';
import EditButton from '../UI/EditButton.vue';
import SelectTaskType from '../UI/SelectTaskType.vue';
import VSelectTooptip from '../UI/VSelectTooptip.vue';
    export default {
        props: {
            taskId: {
                type: Number,
                required: true,
            },
        },
        data() {
            return {
                isShowEditCardDataDialog: false,
                selectedType: '', //присваивается в created
                selectedPriority: '', //присваивается в created,
                selectedTime: '', //присваивается в created,
                priorities : [1,2,3],
                timeFormat: 'ampm',
            }
        },
        store,
        components: {EditButton, VSelectTooptip, SelectTaskType},
        computed: {
            ...mapGetters(['getWindowScreendWidth', 'getDayStatus', 'getTaskData']),
            currentTaskType() {
                return this.getTaskData(this.taskId, 'transformedType');
            },
            currentTaskPriority() {
                return this.getTaskData(this.taskId, 'priority');
            },
            currentTaskTime() {
                return this.getTaskData(this.taskId, 'time');
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
            isMobile() {
                return this.getWindowScreendWidth < 768;
            },
            isTodayAWeekend() {
				return this.getDayStatus === 1;
			},
            types() {
                const getAvailableTypes = (type) => {

                    switch(type) {
                        case 'required job':
                            return ['required job','required task',];
                        case 'non required job':
                            return ['required job','non required job','required task','task'];
                        case 'required task':
                            return ['required job','required task',];
                        case 'task':
                            return ['required job','non required job','required task','task'];
                    }

                    return ['required job','non required job','required task','task'];
                }

				return !this.isTodayAWeekend 
					? getAvailableTypes(this.currentTaskType)
					: [];
			},
        },
        watch: {
            isShowEditCardDataDialog(isDialogOpen) {
                if (isDialogOpen) {
                   this.selectedType = this.currentTaskType;
                } //При открытии диалога всега выбирается текущий тип задания

                if (this.$refs.picker) {
                    const isSelectingMinutes = !this.$refs.picker.selectingHour;
    
                    if (!isDialogOpen && isSelectingMinutes) {
                        this.resetToHourSelection();
                    }
                }
            },
        },
        methods: {
            toggleTimeFormat() {
                this.timeFormat = this.timeFormat === 'ampm' ? '24hr' : 'ampm';
            },

            selectinghourifusehoursonly() {
                this.$nextTick(() => {
                    this.resetToHourSelection();
                });
            },

            resetToHourSelection() {
                this.$refs.picker.selectingHour = true;
            },

            cancelChanges() {
                this.selectedPriority = this.currentTaskPriority;
                this.selectedTime = this.currentTaskTime;
                this.isShowEditCardDataDialog = false;
            },

            getTypeCode(selectedType) {
                const taskTypesMap = new Map([
                    ['task',             1],
                    ['required task',    2],
                    ['non required job', 3],
                    ['required job',     4],
                ])

                return taskTypesMap.get(selectedType);
            },

            saveChanges() {
                this.$emit('saveChanges', {priority: this.selectedPriority, time: this.selectedTime, type: this.getTypeCode(this.selectedType)});
                this.isShowEditCardDataDialog = false;
            }
        },

        created() {
            this.selectedType     = this.currentTaskType;
            this.selectedPriority = this.currentTaskPriority;
            this.selectedTime     = this.currentTaskTime;
        }
    };
</script>

<style>
    .editCardData-content {
        height: 500px;
    }
    
    .editCardData-content::-webkit-scrollbar {
        width: 12px;
    }

    .editCardData-content::-webkit-scrollbar-track {
        background: #e6e6e6;
        border-left: 1px solid #dadada;
    }

    .editCardData-content::-webkit-scrollbar-thumb {
        background: #b0b0b0;
        border: solid 3px #e6e6e6;
        border-radius: 7px;
    }

    .editCardData-content::-webkit-scrollbar-thumb:hover {
        background: rgb(161, 0, 0);
        cursor: pointer;
    }

    @import url('/css/EditCardData/EditCardDataMedia.css');
</style>