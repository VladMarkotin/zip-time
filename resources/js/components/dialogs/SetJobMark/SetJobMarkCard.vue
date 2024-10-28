<template>
    <v-card >
        <v-card-title>
            How successfully was the task completed?
        </v-card-title>
        <v-card-text>
            <v-range-slider
                :tick-labels="seasons"
                :value="[0,1]"
                min="0"
                max="3"
                ticks="always"
                tick-size="4"
            >
                <template v-slot:thumb-label="props">
                    <v-img src="/images/marks/bad_mark_icon.svg"  max-width="40px" 
                    max-height="40px" >
                        
                    </v-img>
                </template>
            </v-range-slider>
        </v-card-text>
    </v-card>
</template>

<script>
    export default {
        data() {
            return {
                test: 0,
                seasons: [
                'Winter',
                'Spring',
                'Summer',
                'Fall',
                ],
                icons: [
                    'mdi-snowflake',
                    'mdi-leaf',
                    'mdi-fire',
                    'mdi-water',
                ],
            }
        },
        methods: {
      season (val) {
        return this.icons[val]
      },
    },
        created() {
            console.log('+++');
        }
    }
</script>

<style>
</style>