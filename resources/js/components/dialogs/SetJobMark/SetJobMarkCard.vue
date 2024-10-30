<template>
    <v-card width="800" flat>
        <v-toolbar color="#a10000" dark >
            <v-toolbar-title>How successfully was the task completed?</v-toolbar-title>
            <v-spacer></v-spacer>
            <span class="close-icon">
                <v-icon
                @click="$emit('toggleSetJobDialog')"
                >
                    mdi-close
                </v-icon>
            </span>
        </v-toolbar>
        <v-card-text>
            <v-row class="d-flex justify-content-center mt-10 mb-3">
                <v-col cols="12" style="flex: 0 0 98% !important;">
                    <v-slider
                        v-model="mark"
                        min          = "1"
                        max          = "4"
                        step         = "1"
                        ticks        = "always"
                        tick-size    = "4"
                        
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
            <v-window
            :value="mark - 1"
            >
                <v-window-item
                v-for="markData in marksData"
                :key="`card-${markData.id}`"
                >
                    <v-row
                    class="fill-height m-0 p-0"
                    align="center"
                    justify="center"
                    >

                        <v-col cols="7">
                            <v-card>
                                <v-card-text class="selected-mark-description">
                                    {{ markData.description }}
                                </v-card-text>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-window-item>
            </v-window>
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
                mark: 1,
            }
        },
        computed: {
            selectedThumbIcon() {
                const {iconName} = this.marksData.find(markData => markData.id === this.mark);
                return `/images/marks/${iconName}`;
            },
            
            tickLabels() {
                return this.marksData.map(({tickLabelDescription}) => tickLabelDescription);
            },

            selectedMarkDescription() {
                const selectedData = this.marksData.find(data => data.id === this.mark);

                if (!selectedData) {
                    return '';
                }

                return selectedData.description;
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

    .selected-mark-description {
        font-size: 16px;
        text-align: justify;
        min-height: 120px;
    }

    .set-mark-card-footer {
        background-color: #a10000;
    }
</style>