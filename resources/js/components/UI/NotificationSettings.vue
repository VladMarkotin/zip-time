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
                        v-model="model"
                        color="red darken-3"
                        dense
                        class="mt-0 cursor-pointer"
                        hide-details
                        ></v-switch>
                </v-col>
                </v-row>
                <v-row 
                class="p-0 m-0"
                >   
                    <v-col class="p-0 m-0 d-flex justify-content-center align-items-center">
                        <span class="label">Extra notifiactions amount</span>
                    </v-col>
                    <v-col class="p-0 m-0 d-flex justify-content-center">
                        <v-slider
                        v-model="fruits"
                        :tick-labels="ticksLabels"
                        track-color="grey"
                        color="red darken-3"
                        min       = "2"
                        max       = "3"
                        step      = "1"
                        ticks     ="always"
                        tick-size ="2"
                        hide-details
                    ></v-slider>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </v-app>
</template>

<script>
    export default {
        props: {
            areNotifiactionsActive: {
                type: Boolean,
                required: true,
            },

            extraNotifiactionsAmount: {
                type: Number,
                required: true
            }
        },
        data () {
        return {
            model: this.areNotifiactionsActive,
            value: 0,
            fruits: 2,
                ticksLabels: [
                '2',
                '3',
                ],
            }
        },
    }
</script>

<style scoped>
    .label {
        font-size: 1.1rem;
        font-weight: 600;
        color: #212529;
    }
</style>