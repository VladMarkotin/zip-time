<template>
    <div>
        <v-dialog v-model="closeDayDialog" persistent max-width="650px">
            <v-card>
                <v-card-title class="subheading font-weight-bold" style="background-color : #A10000;color : white">Close Day</v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row class="d-flex justify-center">
                            <v-col cols="3">
                                <v-text-field v-model="ownMark" label="Own Mark" class="ml-1">
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
                            <v-btn color="#D71700" style="text-color : #ffffff" icon v-on:click="closeDay()" v-bind="attrs" v-on="on">
                                <v-icon md="1" color="#D71700">{{icons.mdiSendClock}}</v-icon>
                            </v-btn>
                        </template>
                        <span>Close Day</span>
                    </v-tooltip>
                    <v-tooltip right>
                        <template v-slot:activator="{on,attrs}">
                            <v-btn color="#D71700" style="text-color : #ffffff" icon v-on:click="hideCloseDayDialog()" v-bind="attrs" v-on="on">
                                <v-icon md="1" color="#D71700">{{icons.mdiCancel}}</v-icon>
                            </v-btn>
                        </template>
                        <span>Cancel</span>
                    </v-tooltip>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="emergencyCallDialog" persistent max-width="650px">
            <v-card>
                <v-card-title class="subheading font-weight-bold" style="background-color : #A10000;color : white">Emergency call</v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col cols="12" sm="7">
                                <v-date-picker v-model="dates" style="height : 325px" color="#A10000" range></v-date-picker>
                            </v-col>
                            <v-col cols="12" sm="5">
                                <v-text-field v-model="dateRangeText" label="Date period" prepend-icon="mdi-calendar" readonly></v-text-field>
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
                            <v-btn color="#D71700" style="text-color : #ffffff" icon v-on:click="callEmergency()" v-bind="attrs" v-on="on">
                                <v-icon md="1" color="#D71700">{{icons.mdiCarEmergency}}</v-icon>
                            </v-btn>
                        </template>
                        <span>Emergency call</span>
                    </v-tooltip>
                    <v-tooltip right>
                        <template v-slot:activator="{on,attrs}">
                            <v-btn color="#D71700" style="text-color : #ffffff" icon v-on:click="hideEmergencyCallDialog()" v-bind="attrs" v-on="on">
                                <v-icon md="1" color="#D71700">{{icons.mdiCancel}}</v-icon>
                            </v-btn>
                        </template>
                        <span>Cancel</span>
                    </v-tooltip>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <AddJobComponent></AddJobComponent>
        <v-data-iterator v-bind:items="['temp']" hide-default-footer>
            <CardsComponent title="Required tasks:" v-bind:items="plan.filter((item) => [4,2].includes(item.type))"></CardsComponent>
            <v-divider></v-divider>
            <CardsComponent title="Non required tasks:" v-bind:items="plan.filter((item) => [3,1].includes(item.type))"></CardsComponent>
        </v-data-iterator>
        <div class="d-flex justify-space-between mt-3">
            <v-tooltip right>
                <template v-slot:activator="{on,attrs}">
                    <v-btn color="#D71700" style="text-color : #ffffff" icon v-bind="attrs" v-on:click="showCloseDayDialog()" v-on="on">
                        <v-icon md="1" color="#D71700" large>{{icons.mdiSendClock}}</v-icon>
                    </v-btn>
                </template>
                <span>Close Day</span>
            </v-tooltip>
            <v-tooltip right>
                <template v-slot:activator="{on,attrs}">
                    <v-btn color="#D71700" style="text-color : #ffffff" icon v-on:click="showEmergencyCallDialog()" v-bind="attrs" v-on="on">
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