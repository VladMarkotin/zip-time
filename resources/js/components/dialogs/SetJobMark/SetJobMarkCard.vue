<template>
    <v-card >
        <v-card-title>
            How successfully was the task completed?
        </v-card-title>
        <v-card-text>
            <v-slider
            vertical
            v-model="test"
            :tick-labels="ticksLabels"
            track-color="grey"
            color="red darken-3"
            :min="0"
            :max="99"
            :step="33"
            ticks="always"
            hide-details
            ></v-slider>
        </v-card-text>
    </v-card>
</template>

<script>
    export default {
        data() {
            return {
                test: 0,
                ticksLabels: ['Bad', 'Normal.', 'Better.', 'Best.'],
            }
        },
        created() {
            console.log('+++');
        }
    }
</script>

<style>
</style>