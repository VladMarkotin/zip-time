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
						<span>Go back</span>
					</v-tooltip>
                    <v-card-title class="emergency-confirmation-title"><p><span class="customRed">Attention!</span> You are about to activate <br/> <span class="customRed">«Emergency mode»</span> !</p></v-card-title>
                    <div style="display: flex; justify-content: center;">
                        <v-card-text class="emergency-confirmation-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam aliquam assumenda hic quia labore odit quis ipsam quas ab iure accusantium architecto exercitationem magni eius commodi at, laudantium, totam velit alias voluptatibus recusandae unde odio ratione. Inventore, libero?</v-card-text>
                    </div>
                    <div class="emergency-confirmation-input-wrapper">
                        <p class="emergency-confirmation-tooltip" v-html="emergencyConfirmationTolltip"></p>
                        <v-text-field 
                        class="confirmation-input"
                        label="Confirmation" 
                        :success = "isTheCheckCompleted"
                        :rules   = "confirmationInputRules"
                        v-model  = "confirmationInputValue"
                        @keypress.enter = "callEmergency"
                        ></v-text-field>
                    </div>
                    <ul class="emergencyMode-warning-list">
                        <li class="emergencyMode-warning-li">Activating Emergency Mode is a last resort!</li>
                        <li class="emergencyMode-warning-li">You won't be able to cancel it afterwards, and during its activation, certain app functionalities will be unavailable!</li>
                    </ul>
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
            isTheCheckCompleted: {
                type: Boolean,
            }
        },
        data() {
            return {
                icons : {mdiStepBackward}, 
                CONFIRMATION_TEXT: 'Agree',
                confirmationInputRules: [(inputVal) => {
                    return (inputVal && inputVal.trim().toLowerCase() === this.CONFIRMATION_TEXT.trim().toLowerCase()) || false;
                }],
                confirmationInputValue: '',
            }
        },
        watch: {
            confirmationInputValue() {
                const checkResult = this.confirmationInputRules.map(check => check(this.confirmationInputValue))
                                                  .every(checkResult => checkResult === true);

                this.setIsTheCheckCompleted(checkResult);
            }
        },
        computed: {
            emergencyConfirmationTolltip() {
                const formatedDates = this.emergencyModeDates.map(date => {
                    let parts = date.split('-'); 
                    return `${parts[2]}.${parts[1]}.${parts[0]}`;
                });
                
                let text = 'If you are sure that you want to activate "Emergency Mode"<br/>'

                if (formatedDates.length === 1) {
                    text += `on ${formatedDates[0]}, `;
                } else {
                    text += `from the ${formatedDates[0]} to the ${formatedDates[1]}, `;
                }

                text += `enter "${this.CONFIRMATION_TEXT}"`;
                return text;
            }
        },
        methods: {
            setIsTheCheckCompleted(checkResult) {
                this.$emit('setIsTheCheckCompleted', checkResult);
            },

            callEmergency() {
                if (this.isTheCheckCompleted) {
                   this.$emit('callEmergency');
                }
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

    .emergency-confirmation-input-wrapper {
        margin: 16px 0;
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
    }

    .emergency-confirmation-tooltip {
        margin-bottom: 0;
        text-align: center;
        font-size: 15px;
        font-weight: 500;
        line-height: 1.1rem;
        color: #6C6960;
    }

    .emergencyMode-warning-list {
        margin: 0 auto;
        max-width: 90%;
        padding: 0;
        display: flex;
        flex-direction: column;
        text-align: center;
        gap: 12px;
        /* color: #D53032; */
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3); /* сдвиг 1px, размытие 3px, более светлая тень */
    }

    .emergencyMode-warning-list .emergencyMode-warning-li {
        font-size: 18px;
        font-weight: 600;
    }

    @import url('/css/EmergencyConfirmation/EmergencyConfirmationMedia.css');
</style>