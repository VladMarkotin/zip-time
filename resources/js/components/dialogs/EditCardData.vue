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
        <v-card>
            <v-card-title> Edit card </v-card-title>
            <v-card-text>
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
                    ref="picker"
                    v-model="selectedTime"
                    color="#D71700"
                    :format="timeFormat"
                    @click:hour="selectinghourifusehoursonly"
                    > </v-time-picker>
                    <v-row class="p-0 m-0">
                        <v-btn 
                        @click="toggleTimeFormat">
                        Toggle Time Format
                        </v-btn>
                    </v-row>
                </v-row>
            </v-card-text>
            <v-spacer></v-spacer>
            <v-card-actions>
                <v-btn
                    color="green-darken-1"
                    variant="text"
                    @click="cancelChanges"
                >
                    Cancel
                </v-btn>
                <v-btn
                    color="green-darken-1"
                    variant="text"
                    @click="saveChanges"
                >
                    Save
                </v-btn>
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
