<template>
    <v-menu 
    v-bind:close-on-content-click="false" 
    >
        <template v-slot:activator="{on}">
            <v-text-field 
            label="Time" 
            prepend-icon="mdi-clock-time-four-outline" 
            readonly 
            v-model="selectedTime" 
            v-on="on"></v-text-field>
        </template>
        <v-time-picker
        ref="picker"
        v-model="selectedTime"
        color="#D71700"
        @input="updateSelectedTime"
        :format="timeFormat"
        >
        </v-time-picker>
        <v-btn 
        @click="toggleTimeFormat">
            Toggle Time Format
        </v-btn>
    </v-menu>
</template>

<script>
    export default {
        props: {
            time: {
                type: String,
                required: true,
            }
        },
        data() {
            return {
                selectedTime: this.time,
                timeFormat: 'ampm',
            }
        },
        methods: {
            updateSelectedTime(newTime) {
                
                this.$emit('updateTime', newTime);
            },

            toggleTimeFormat() {
                this.timeFormat = this.timeFormat === 'ampm' ? '24hr' : 'ampm';
            },
        },
    }
</script>
