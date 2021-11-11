<template>
    <div>
        <v-dialog v-model="dialog" persistent max-width="650px">
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
                                <v-textarea outlined rows="2" row-height="4" shaped placeholder="Comment" counter="256" v-model="comment"></v-textarea>
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
                            <v-btn color="#D71700" style="text-color : #ffffff" icon v-on:click="hideDialog()" v-bind="attrs" v-on="on">
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
            <CardComponent title="Required tasks:" v-bind:items="plan.filter((item) => [4,2].includes(item.type))"></CardComponent>
            <v-divider></v-divider>
            <CardComponent title="Non required tasks:" v-bind:items="plan.filter((item) => [3,1].includes(item.type))"></CardComponent>
        </v-data-iterator>
        <div class="d-flex justify-space-between mt-3">
            <v-tooltip right>
                <template v-slot:activator="{on,attrs}">
                    <v-btn color="#D71700" style="text-color : #ffffff" icon v-bind="attrs" v-on:click="" v-on="on">
                        <v-icon md="1" color="#D71700" large>{{icons.mdiSendClock}}</v-icon>
                    </v-btn>
                </template>
                <span>Close Day</span>
            </v-tooltip>
            <v-tooltip right>
                <template v-slot:activator="{on,attrs}">
                    <v-btn color="#D71700" style="text-color : #ffffff" icon v-on:click="showDialog()" v-bind="attrs" v-on="on">
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
    import CardComponent from './CardComponent.vue'
    import {minLength,maxLength} from 'vuelidate/lib/validators'
    import {mdiSendClock,mdiCarEmergency,mdiCancel} from '@mdi/js'
    export default
    {
        components : {AddJobComponent,CardComponent},
        props : ['plan'],
        data()
        {
            const currDate = new Date()
            return {icons : {mdiSendClock,mdiCarEmergency,mdiCancel},dialog : false,dates : [currDate.toEnStr(),currDate.addDays(10).toEnStr()],comment : ''}
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
            async callEmergency()
            {
                const response = await axios.post('/emergency',{from : this.dates[0],to : this.dates[1],comment : this.comment})
            },
            showDialog()
            {
                this.dialog = true
            },
            hideDialog()
            {
                this.dialog = false
            }
        }
    }
</script>