<template>
    <v-dialog 
    v-model="isShowEditCardDataDialog" 
    persistent 
    width="500">
        <template v-slot:activator="{ props }">
            <template>
                <EditButton @click="isShowEditCardDataDialog = true" />
            </template>
        </template>
        <v-card class="pt-3 pb-3">
            <v-card-text class="pb-2">
                <v-row class="p-0 m-0">
                    <h4 class="p-0" style="font-size: 1rem;">Edit task`s priority:</h4>
    
                    <v-select
                        :items="priorities"
                        v-model="selectedPriority"
                        label="Set Priority"
                        solo
                    ></v-select>
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
            <v-spacer></v-spacer>
            <v-card-actions>
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
import EditButton from '../UI/EditButton.vue';
    export default {
        props: {
            currentTaskPriority: {
                type: Number,
                required: true,
            },

            currentTaskTime: {
                type: String,
                required: true
            }
        },
        data() {
            return {
                isShowEditCardDataDialog: false,
                selectedPriority: this.currentTaskPriority,
                selectedTime: this.currentTaskTime,
                priorities : [1,2,3],
                timeFormat: 'ampm',
            }
        },
        components: {EditButton,},
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

            saveChanges() {
                this.$emit('saveChanges', {priority: this.selectedPriority, time: this.selectedTime});
                this.isShowEditCardDataDialog = false;
            }
        },

    };
</script>