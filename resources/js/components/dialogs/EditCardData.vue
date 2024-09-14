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
import VSelectTooptip from '../UI/VSelectTooptip.vue';
    export default {
        props: {
            currentTaskPriority: {
                type: Number,
                required: true,
            },

            currentTaskTime: {
                type: String,
                required: true
            },
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
        store,
        components: {EditButton, VSelectTooptip},
        computed: {
            ...mapGetters(['getWindowScreendWidth']),
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
            }
        },
        watch: {
            isShowEditCardDataDialog(isDialogOpen) {
                if (this.$refs.picker) {
                    const isSelectingMinutes = !this.$refs.picker.selectingHour;
    
                    if (!isDialogOpen && isSelectingMinutes) {
                        this.resetToHourSelection();
                    }
                }
            }
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

            saveChanges() {
                this.$emit('saveChanges', {priority: this.selectedPriority, time: this.selectedTime});
                this.isShowEditCardDataDialog = false;
            }
        },

    };
</script>

<style>
    .editCardData-content {
        height: 500px;
    }
    
    @import url('/css/EditCardData/EditCardDataMedia.css');
</style>