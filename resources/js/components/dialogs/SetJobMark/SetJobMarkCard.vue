<template>
    <v-card width="800" flat>
        <v-toolbar color="#a10000" dark >
            <v-toolbar-title>How successfully was the task completed?</v-toolbar-title>
            <v-spacer></v-spacer>
            <span class="close-icon">
                <v-icon>mdi-close</v-icon>
            </span>
        </v-toolbar>
        <v-card-text class="mt-14">
            <v-row class="d-flex justify-content-center">
                <v-col cols="12">
                    <v-slider
                        v-model="mark"
                        min          = "0"
                        max          = "99"
                        step         = "33"
                        ticks        = "always"
                        tick-size    = "4"
                        thumb-label  = "always"
                        :tick-labels = "tickLabels"
                    >
                        <template v-slot:thumb-label="props">
                            <v-img 
                            :src="selectedThumbIcon"  
                            max-width="40px" 
                            max-height="40px" >
                                
                            </v-img>
                        </template>
                    </v-slider>
                </v-col>
            </v-row>
            <v-row class="d-flex justify-content-center">
                <v-col cols="6">
                    <v-card>
                        <v-card-text>Today I didn't manage to complete this task, but I’m committed to learning from it and I know I'll succeed in the future.</v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
</template>

<script>
    export default {
        props: {
            marksData: {
                type: Array,
                required: true,
            }
        },
        data() {
            return {
                mark: 0,
            }
        },
        computed: {
            selectedThumbIcon() {
                const {iconName} = this.marksData.find(markData => markData.mark === this.mark);
                return `/images/marks/${iconName}`;
            },
            tickLabels() {
                return this.marksData.map(({tickLabelDescription}) => tickLabelDescription);
            }
        },
       
    }
</script>

<style scoped>
    .close-icon {
        cursor: pointer;
        transition: all .3s ease;
    }

    .close-icon:hover {
        transform: rotate(3deg);
    }
</style>