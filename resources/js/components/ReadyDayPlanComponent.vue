<template>
    <div>
        <v-dialog persistent max-width="650px" v-model="closeDayDialog">
            <v-card>
                <v-card-title class="subheading font-weight-bold" style="background-color : #A10000;color : white">Close Day</v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row class="d-flex justify-center">
                            <v-col cols="3">
                                <v-text-field label="Own Mark" class="ml-1" v-model="ownMark">
                                    <v-icon slot="append">mdi-percent</v-icon>
                                </v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col>
                                <v-textarea outlined rows="2" row-height="4" shaped label="Comment" counter="256" v-model="closeDayComment"></v-textarea>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions class="justify-space-between">
                    <v-tooltip right>
                        <template v-slot:activator="{on,attrs}">
                            <v-btn color="#D71700" icon style="text-color : #ffffff" v-bind="attrs" v-on="on" v-on:click="closeDay()">
                                <v-icon md="1" color="#D71700">{{icons.mdiSendClock}}</v-icon>
                            </v-btn>
                        </template>
                        <span>Close Day</span>
                    </v-tooltip>
                    <v-tooltip right>
                        <template v-slot:activator="{on,attrs}">
                            <v-btn color="#D71700" icon style="text-color : #ffffff" v-bind="attrs" v-on="on" v-on:click="hideCloseDayDialog()">
                                <v-icon md="1" color="#D71700">{{icons.mdiCancel}}</v-icon>
                            </v-btn>
                        </template>
                        <span>Cancel</span>
                    </v-tooltip>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog persistent max-width="650px" v-model="emergencyCallDialog">
            <v-card>
                <v-card-title class="subheading font-weight-bold" style="background-color : #A10000;color : white">Emergency call</v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col cols="12" sm="7">
                                <v-date-picker color="#A10000" range style="height : 325px" v-model="dates"></v-date-picker>
                            </v-col>
                            <v-col cols="12" sm="5">
                                <v-text-field label="Date period" prepend-icon="mdi-calendar" readonly v-model="dateRangeText"></v-text-field>
                            </v-col>
                        </v-row>                            
                        <v-row>
                            <v-col cols="12">
                                <v-textarea outlined rows="2" row-height="4" shaped label="Comment" counter="256" v-model="emergencyCallComment"></v-textarea>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions class="justify-space-between">
                    <v-tooltip right>
                        <template v-slot:activator="{on,attrs}">
                            <v-btn color="#D71700" icon style="text-color : #ffffff" v-bind="attrs" v-on="on" v-on:click="callEmergency()">
                                <v-icon md="1" color="#D71700">{{icons.mdiCarEmergency}}</v-icon>
                            </v-btn>
                        </template>
                        <span>Emergency call</span>
                    </v-tooltip>
                    <v-tooltip right>
                        <template v-slot:activator="{on,attrs}">
                            <v-btn color="#D71700" icon style="text-color : #ffffff" v-bind="attrs" v-on="on" v-on:click="hideEmergencyCallDialog()">
                                <v-icon md="1" color="#D71700">{{icons.mdiCancel}}</v-icon>
                            </v-btn>
                        </template>
                        <span>Cancel</span>
                    </v-tooltip>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <AddJobComponent></AddJobComponent>
        <v-data-iterator hide-default-footer v-bind:items="['temp']">
            <CardsComponent title="Required tasks:" v-bind:items="plan.filter((item) => [4,2].includes(item.type))"></CardsComponent>
            <v-divider></v-divider>
            <CardsComponent title="Non required tasks:" v-bind:items="plan.filter((item) => [3,1].includes(item.type))"></CardsComponent>
        </v-data-iterator>
        <div class="d-flex justify-space-between mt-3">
            <v-tooltip right>
                <template v-slot:activator="{on,attrs}">
                    <v-btn color="#D71700" icon style="text-color : #ffffff"  v-bind="attrs" v-on="on" v-on:click="showCloseDayDialog()">
                        <v-icon md="1" color="#D71700" large>{{icons.mdiSendClock}}</v-icon>
                    </v-btn>
                </template>
                <span>Close Day</span>
            </v-tooltip>
            <v-tooltip right>
                <template v-slot:activator="{on,attrs}">
                    <v-btn color="#D71700" icon style="text-color : #ffffff" v-bind="attrs" v-on="on" v-on:click="showEmergencyCallDialog()">
                        <v-icon md="1" color="#D71700">{{icons.mdiCarEmergency}}</v-icon>
                    </v-btn>
                </template>
                <span>Emergency call</span>
            </v-tooltip>
        </div>
    </div>
</template>
<script>
    import AddJobComponent from './AddJobComponent.vue'
    import CardsComponent from './CardsComponent.vue'
    import {minLength,maxLength} from 'vuelidate/lib/validators'
    import {mdiSendClock,mdiCarEmergency,mdiCancel} from '@mdi/js'
    export default
    {
        components : {AddJobComponent,CardsComponent},
        props : ['plan'],
        data()
        {
            const currDate = new Date()
            return {
                    icons : {mdiSendClock,mdiCarEmergency,mdiCancel},
                    emergencyCallDialog : false,
                    closeDayDialog : false,
                    dates : [currDate.toEnStr(),currDate.addDays(2).toEnStr()],
                    ownMark : '',
                    closeDayComment : '',
                    emergencyCallComment : ''
                }
        },
        computed :
        {
            dateRangeText()
            {
                return this.dates.join(' - ')
            }
        },
        methods :
        {
            async closeDay()
            {
                const response = await axios.post('/closeDay',{ownMark : this.ownMark,comment : this.closeDayComment})
                this.hideCloseDayDialog()
            },
            async callEmergency()
            {
                const response = await axios.post('/emergency',{from : this.dates[0],to : this.dates[1],comment : this.emergencyCallComment})
                this.hideEmergencyCallDialog()
            },
            showCloseDayDialog()
            {
                this.closeDayDialog = true
            },
            hideCloseDayDialog()
            {
                this.closeDayDialog = false
            },
            showEmergencyCallDialog()
            {
                this.emergencyCallDialog = true
            },
            hideEmergencyCallDialog()
            {
                this.emergencyCallDialog = false
            }
        }
    }
</script>