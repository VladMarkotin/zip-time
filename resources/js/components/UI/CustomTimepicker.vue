<template>
    <v-menu 
    v-model="menu"
    v-bind:close-on-content-click="false" 
    @input="onMenuToggled"

    >
        <template v-slot:activator="{on}">
            <v-text-field 
            label="Time" 
            :prepend-icon="isIconInner ? '' : 'mdi-clock-time-four-outline'"
            :prepend-inner-icon="isIconInner ? 'mdi-clock-time-four-outline' : ''"
            readonly 
            v-model="selectedTime" 
            v-on="on"></v-text-field>
        </template>
        <v-card style="text-align: center;">
            <v-time-picker
            ref="picker"
            v-model="selectedTime"
            color="#D71700"
            :format="timeFormat"
            @click:hour="selectinghourifusehoursonly"
            @input="updateSelectedTime"
            >
            </v-time-picker>
            <v-card-actions class="px-4 d-flex justify-content-center align-items-center" style="background-color: #FFFFFF;">
                <v-btn 
                @click="toggleTimeFormat">
                    Toggle Time Format
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-menu>
</template>

<script>
    export default {
        props: {
            time: {
                type: String,
                required: true,
            },

            isIconInner: {
                type: Boolean,
                default: false,
            },
        },
        data() {
            return {
                menu: false,
                selectedTime: this.time,
                timeFormat: 'ampm',
            }
        },

        watch: {
            time(newVal) {
                this.selectedTime = newVal;
            }
        },

        methods: {
            updateSelectedTime(newTime) {
                this.$emit('updateTime', newTime);
            },

            toggleTimeFormat() {
                this.timeFormat = this.timeFormat === 'ampm' ? '24hr' : 'ampm';
            },
            
            selectinghourifusehoursonly() {
                this.$nextTick(() => {
                    this.resetToHourSelection();
                });
            },

            onMenuToggled(val) {
                if (!val) {
                    this.resetToHourSelection();
                }
            },

            resetToHourSelection() {
                this.$refs.picker.selectingHour = true;
            }
        },
    }
</script>
