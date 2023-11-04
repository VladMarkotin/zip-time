<template>
    <v-menu 
    ref="v-menu" 
    v-bind:close-on-content-click="false" 
    v-model="menu" 
    content-class="addJobTask-timePicker-wrapper"
    >
        <template v-slot:activator="{ on: showTimePicker }">
            <v-row class="p-0 m-0">
                <v-col cols="1" class="p-0 m-0 d-flex flex-column justify-content-center">
                    <v-tooltip left>
                        <template v-slot:activator="{ on: tooltip }">
                            <v-btn icon v-on="{ ...tooltip, ...showTimePicker }">
                                <v-icon>
                                    {{ icon.mdiClockTimeFourOutline }}
                                </v-icon>
                            </v-btn>
                        </template>
                        <span>Edit time</span>
                    </v-tooltip>
                </v-col>
                <v-col class="p-0 m-0">
                    <v-text-field label="Time" readonly v-model="timeParent" v-on="showTimePicker"></v-text-field>
                </v-col>
                <v-col cols="1" class="p-0 m-0">
                </v-col>
            </v-row>
        </template>
        <v-card>
            <v-container class="p-0">
                <v-row class="d-flex justify-content-center">
                    <v-col>
                        <v-time-picker full-width color="#D71700" v-on:click:minute="$refs['v-menu'].save(time)"
                            v-model="time" />
                    </v-col>
                </v-row>
                <v-divider></v-divider>
                <v-row class="d-flex justify-content-end align-items-center pr-4 pl-4">
                    <v-col cols="auto" class="p">
                        <template>
                            <CloseButton @close="menu = false" />
                        </template>
                    </v-col>
                </v-row>
            </v-container>
        </v-card>
    </v-menu>
</template>

<script>
import CloseButton from './UI/CloseButton.vue';
import {mdiClockTimeFourOutline} from '@mdi/js';
    export default {
        props: {
            menuParent: {
                required: true,
            },

            timeParent: {
                required: true,
            },
        },

        components: {CloseButton},

        data() {
            return {
                icon: {mdiClockTimeFourOutline},
                menu: false,
                time : '01:00'
            }
        },

        watch: {
            menu() {
                this.$emit('changeMenuModel', this.menu);
            },
            time() {
                console.log(this.time);
                this.$emit('changeTimeModel', this.time);
            },
        },

        created() {
            this.menu = this.menuParent;
            this.time = this.timeParent;
        }
    }
</script>