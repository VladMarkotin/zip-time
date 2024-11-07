<template>
    <v-card width="500" flat>
        <v-toolbar color="#a10000" dark class="card-header">
            <v-toolbar-title class="card-header-title">How successfully was the task completed?</v-toolbar-title>
            <v-spacer></v-spacer>
            <span class="close-icon d-flex justify-content-end">
                <v-icon
                @click="$emit('closeSetJobDialog')"
                >
                    mdi-close
                </v-icon>
            </span>
        </v-toolbar>
        <v-card-text :style="cardTextStyles" class="card-content">
            <v-row class="d-flex justify-content-center mt-10 mb-3">
                <v-col :cols="isMobile ? 10 : 11" style="flex: 0 0 98% !important;">
                    <v-slider
                        v-model="selectedMarkId"
                        min          = "1"
                        max          = "4"
                        step         = "1"
                        ticks        = "always"
                        tick-size    = "4"
                        track-color  = "#DBD7D2"
                        color        = "#CD5C5C"
                        thumb-size   = "35"
                        hide-details
                    >
                        <template v-slot:thumb-label="props">
                            <v-img 
                            :src="selectedThumbIcon"  
                            width="35px" 
                            height="35px" >
                                
                            </v-img>
                        </template>
                    </v-slider>
                </v-col>
            </v-row>
            <v-window
            :value="selectedMarkId - 1"
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

                        <v-col :cols="isMobile ? 12 : 11">
                            <v-card>
                                <v-card-title class="description-title">
                                {{ markData.descriptionTitle }}</v-card-title>
                                <v-card-text class="selected-mark-description">
                                    {{ markData.description }}
                                </v-card-text>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-window-item>
            </v-window>
        </v-card-text>
        <v-divider class="m-0" />
        <v-card-actions class="d-flex justify-content-center p-3">
            <v-btn
            class="p-3"
            rounded
            @click="sendMark"
            >
                <span class="mr-4">Estimate Job as </span>
                <v-img 
                :src="selectedThumbIcon"  
                max-width="40px" 
                max-height="40px" />
            </v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
    import store from '../../../store';
    import {mapGetters,} from 'vuex/dist/vuex.common.js';
    export default {
        props: {
            marksData: {
                type: Array,
                required: true,
                
            },
            jobMark: {
                type: Number,
                required: true,
            }
        },
        data() {
            return {
                selectedMarkId: 1, // присваивается в хуке created
            }
        },
        store,
        emits: ['closeSetJobDialog' , 'sendMark'],
        computed: {
            ...mapGetters(['getWindowScreendWidth']),
            selectedThumbIcon() {
                const iconName = this.getMarkDataProperty('iconName');
                return `/images/marks/${iconName}`;
            },
            
            tickLabels() {
                return this.marksData.map(({descriptionTitle}) => descriptionTitle);
            },

            selectedMarkDescription() {
                const selectedData = this.getMarkDataProperty();

                if (!selectedData) {
                    return '';
                }

                return selectedData.description;
            },
            cardTextStyles() {
                if (!this.isMobile) {
                    return {};
                }
                return {'height': '450px'};
            },
            isMobile() {
                return this.getWindowScreendWidth < 768;
            }
        },
        methods: {
            sendMark() {
                const mark = this.getMarkDataProperty('mark');
                this.$emit('sendMark', mark);
            },

            getMarkDataProperty(key = 'allProperty') {
                const markData = this.marksData.find(markData => markData.id === this.selectedMarkId);

                if (key === 'allProperty') {
                    return markData;
                }

                return markData[key];
            }
        },
        created() {
            this.selectedMarkId = this.marksData.find(markData => markData.mark === this.jobMark).id;
        }
    }
</script>

<style scoped>
    .card-content {
        padding: 12px !important;
    }

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

    ::v-deep .v-slider__thumb-label {
        background-color: #fff !important;
    }

    .description-title {
        justify-content: center;
        text-align: center;
        word-break: break-word;
    }

    @media screen and (max-width: 550px) {
        .card-header {
            padding: 6px !important;
        }

        .card-header ::v-deep .v-toolbar__content {
           padding: 0px !important;
           display: grid !important;
           grid-template-columns: auto auto;
           grid-row-gap: 25px;
        }

        .card-header .card-header-title {
            grid-column: 1/3;
            grid-row: 2/3;
            text-align: center;
            word-break: break-word;
            width: 100%;
            white-space: normal;
        }
}
</style>