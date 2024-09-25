<template>
    <v-app>
        <v-card class="mt-2 p-2">
            <v-card-text>
                <div>
                </div>
                <v-row 
                class="p-0 m-0 mb-2"
                >   
                    <v-col class="p-0 m-0 d-flex justify-content-center align-items-center">
                        <span class="label">Are notifiactions active?</span>
                    </v-col>
                    <v-col class="p-0 m-0 d-flex justify-content-center">
                        <v-switch
                        v-model="areNotifiactionsActive"
                        color="red darken-3"
                        dense
                        class="mt-0 cursor-pointer"
                        hide-details
                        @change="debounceSendSettings"
                        ></v-switch>
                </v-col>
                </v-row>
                <v-row 
                class="p-0 m-0"
                >   
                    <v-col class="p-0 m-0 d-flex justify-content-center align-items-center">
                        <span class="label">Number of additional notifications per day</span>
                    </v-col>
                    <v-col class="p-0 m-0 d-flex justify-content-center">
                        <v-slider
                        v-model="additionalNotificationsCount"
                        :tick-labels="additionalNotificationsLabels"
                        track-color="grey"
                        color="red darken-3"
                        min       = "2"
                        max       = "3"
                        step      = "1"
                        ticks     ="always"
                        tick-size ="2"
                        hide-details
                        @change="debounceSendSettings"
                    ></v-slider>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </v-app>
</template>

<script>
import { debounce } from 'lodash';
    export default {
        props: {
            areNotifiactionsEnabled: {
                type: Boolean,
                required: true,
            },

            notificationsCount: {
                type: Number,
                required: true
            }
        },
        data () {
            return {
                areNotifiactionsActive: this.areNotifiactionsEnabled,
                additionalNotificationsCount: this.notificationsCount,
                additionalNotificationsLabels: ['2','3'],
                DEBOUNCER_DELAY: 700, //тут менять после скольки мс после клика пойдет запрос
                }
        },
        computed: {
            debouncedSendSettings() {
                return debounce(function(callback) {
                    callback();
                }, this.DEBOUNCER_DELAY)
            }
        },
        methods: {
            debounceSendSettings() {
                this.debouncedSendSettings(async() => {
                    try {
                        const url = 'settings-save-notify'; //тут указать куда запрос отправляется
                        const params = {
                            areNotifiactionsActive:       this.areNotifiactionsActive,
                            additionalNotificationsCount: this.additionalNotificationsCount,
                        }; 

                        const response = await axios.post(url, params); 

                    } catch(error) {
                        console.error(error);
                    }
                });
            }
        }
    }
</script>

<style scoped>
    .label {
        font-size: 1.1rem;
        font-weight: 600;
        color: #212529;
    }
</style>