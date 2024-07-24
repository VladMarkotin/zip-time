<template>
    <div class="emergency-confirmation-container">
        <v-card-text>
            <v-container>
                <v-tooltip right>
						<template v-slot:activator="{on}">
							<v-btn 
								icon 
								v-on="on" 
								@click="$emit('goBackOneStep')"
								>
								<v-icon color="#D71700" large>{{icons.mdiStepBackward}}</v-icon>
							</v-btn>
						</template>
						<span>Go back one step</span>
					</v-tooltip>
                    <v-card-title class="emergency-confirmation-title"><p><span class="customRed">Attention!</span> You are about to activate <br/> <span class="customRed">«Emergency mode»</span> !</p></v-card-title>
                    <div style="display: flex; justify-content: center;">
                        <v-card-text class="emergency-confirmation-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam aliquam assumenda hic quia labore odit quis ipsam quas ab iure accusantium architecto exercitationem magni eius commodi at, laudantium, totam velit alias voluptatibus recusandae unde odio ratione. Inventore, libero?</v-card-text>
                    </div>
                    <p>{{ emergencyConfirmationTolltip }}</p>
            </v-container>
        </v-card-text>
    </div>
</template>

<script>
import {mdiStepBackward} from '@mdi/js'
    export default {
        props: {
            emergencyModeDates: {
                type: Array,
            },
        },
        data() {
            return {
                icons : {mdiStepBackward}, 
            }
        },
        computed: {
            emergencyConfirmationTolltip() {
                const formatedDates = this.emergencyModeDates.map(date => {
                    let parts = date.split('-'); 
                    return `${parts[2]}.${parts[1]}.${parts[0]}`;
                });

                let text = 'If you are sure that you want to activate Emergency Mode '

                if (formatedDates.length === 1) {
                    text += `on ${formatedDates[0]}`;
                } else {
                    text += `from the ${formatedDates[0]} to the ${formatedDates[1]}`;
                }
                console.log(text);
                return ''
            }
        }
    }
</script>

<style scoped>
    .emergency-confirmation-container {
        min-height: 515px;
    }

    .emergency-confirmation-title {
        text-align: center;
        font-size: 26px;
        justify-content: center;
        font-weight: 600;
    }

    .emergency-confirmation-title p {
        margin-bottom: 0 !important;
    }

    .customRed {
        color: #D71700 !important;
    }

    .emergency-confirmation-text {
        max-width: 80% !important;
        text-align: justify;
        font-size: 16px;
        padding: 0;
    }
</style>