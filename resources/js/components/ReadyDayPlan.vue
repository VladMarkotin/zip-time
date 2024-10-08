<template>
    <div>
        <template v-if="isShowAddJobTaskDialog">
            <AddJobTask
                v-bind:dayStatus = "data.dayStatus"
                v-on:setAlertData           = "setAlertData"
                v-on:toggleAddJobTaskDialog = "toggleAddJobTaskDialog"
                v-on:toggleAlertDialog      = "toggleAlertDialog"
            />
        </template>
        <div class="card-demo"></div>
        <template v-if="isShowCloseDayDialog">
            <CloseDay 
                v-on:toggleCloseDayDialog = "toggleCloseDayDialog" 
                @showFirework             = "isShowFirework = true"
                />
        </template>
        <template v-if="isShowEmergencyCallDialog">
            <EmergencyCall
                v-on:toggleEmergencyCallDialog="toggleEmergencyCallDialog"
            />
        </template>
        <template v-if="isShowAlertDialog">
            <Alert
                v-bind:type="alert.type"
                v-bind:text="alert.text"
                v-on:toggleAlertDialog="toggleAlertDialog"
            />
        </template>
        
        <v-data-iterator hide-default-footer v-bind:items="data.plan">
            <Cards
                title="Required jobs and tasks"
                v-if="isExistsRequiredTasks"
                v-bind:items="getRequiredTasks"
            />
            <v-divider></v-divider>
            <Cards
                title="Non required jobs and tasks"
                v-if="isExistsNonRequiredTasks"
                v-bind:items="getNonRequiredTasks"
            />
        </v-data-iterator>
        <div class="d-flex justify-space-between mt-6">
            <v-tooltip right>
                <template v-slot:activator="{ on }">
                    <v-btn icon v-on="on" v-on:click="toggleAddJobTaskDialog">
                        <v-icon color="#D71700" large>{{
                            icons.mdiPlusBox
                        }}</v-icon>
                    </v-btn>
                </template>
                <span>Add job/task</span>
            </v-tooltip>
            <v-tooltip right>
                <template v-slot:activator="{ on }">
                    <v-btn icon v-on="on" v-on:click="toggleCloseDayDialog">
                        <v-icon color="#D71700" large>{{
                            icons.mdiSendClock
                        }}</v-icon>
                    </v-btn>
                </template>
                <span>Close day</span>
            </v-tooltip>
            <v-tooltip right>
                <template v-slot:activator="{ on }">
                    <v-btn
                        icon
                        v-on="on"
                        v-on:click="toggleEmergencyCallDialog"
                    >
                        <v-icon color="#D71700" large>{{
                            icons.mdiCarEmergency
                        }}</v-icon>
                    </v-btn>
                </template>
                <span>Emergency mode</span>
            </v-tooltip>
        </div>
        <Firework v-if="isShowFirework"/>
    </div>
</template>
<script>
import Alert from "./dialogs/Alert.vue";
import AddJobTask from "./dialogs/AddJobTask.vue";
import CloseDay from "./dialogs/CloseDay.vue";
import Cards from "./cards/Cards.vue";
import EmergencyCall from "./dialogs/EmergencyMode/EmergencyCall.vue";
import Challenges from "./challenges/Challenges.vue";
import Firework from "./UI/Firework.vue";
import { mdiCarEmergency, mdiPlusBox, mdiSendClock } from "@mdi/js";
import "intro.js/introjs.css";
import store from "../store";
import { mapMutations, mapGetters } from "vuex/dist/vuex.common.js";

export default {
    components: { Alert, AddJobTask, CloseDay, Cards, EmergencyCall, Challenges, Firework },
    props: ["data"],
    data() {
        return {
            icons: { mdiCarEmergency, mdiPlusBox, mdiSendClock },

            isShowAddJobTaskDialog: false,
            isShowCloseDayDialog: false,
            isShowEmergencyCallDialog: false,
            isShowAlertDialog: false,

            alert: { type: "", text: "" },
            isShowFirework: false,
        };
    },
    store,
    computed: {
        ...mapGetters(['getRequiredTasks', 'getNonRequiredTasks']),

        isExistsRequiredTasks() {
            return this.getRequiredTasks.length;
        },

        isExistsNonRequiredTasks() {
            return this.getNonRequiredTasks.length;
        },
    },
    methods: {
        ...mapMutations(['INITIALIZE_DETAILS_STORE', 'INITIALIZE_NOTES_STORE', 'INITIALIZE_TASK_DATA_STORE', 'SET_WINDOW_SCREEN_WIDTH']),

        toggleAddJobTaskDialog() {
            this.isShowAddJobTaskDialog = !this.isShowAddJobTaskDialog;
        },
        toggleCloseDayDialog() {
            this.isShowCloseDayDialog = !this.isShowCloseDayDialog;
        },
        toggleEmergencyCallDialog() {
            this.isShowEmergencyCallDialog = !this.isShowEmergencyCallDialog;
        },

        setAlertData(type, text) {
            this.alert.type = type;
            this.alert.text = text;
        },
        toggleAlertDialog() {
            this.isShowAlertDialog = !this.isShowAlertDialog;
        },

        updateScreenWidth() {
            this.SET_WINDOW_SCREEN_WIDTH({windowScreenWidth: window.innerWidth});
        }
    },

    created() {
        
        const detailsData = this.data.plan.map(taskData => ({
            detailsData: taskData.detailsData,
            detailsCompletedPercent: taskData.detailsCompletedPercent,
            key: taskData.taskId,
        }));

        const notesData = this.data.plan.map(taskData => ({
            key: taskData.taskId,
            notesData: taskData.notesData,
        }));
        
        this.INITIALIZE_DETAILS_STORE({detailsData});
        this.INITIALIZE_NOTES_STORE({notesData});
        this.INITIALIZE_TASK_DATA_STORE({taskData: this.data.plan, dayStatus: this.data.dayStatus});
    },

    async mounted() {
        window.addEventListener('resize', this.updateScreenWidth);

        try {
            const response = await axios.post("/getEduStep", {});
            let currentEduStep = response.data.edu_step;
            if (currentEduStep == 2) {
                const introJS = require("intro.js").introJs();
                require("/css/customTooltip.css");

                introJS
                    .setOptions({
                        tooltipClass: "custom-tooltip",
                        hidePrev: true,
                        hideNext: true,
                        disableInteraction: true,
                        exitOnOverlayClick: false,
                        showStepNumbers: false,
                        steps: [
                            {
                                element: document.getElementById("card-wrapper"),
                                intro: "This is task`s card view",
                                position: "right",
                            },
                            {
                                element: document.getElementById("card-details"),
                                intro: "Here you can divide your job/task on subtasks",
                                position: "right",
                            },
                            {
                                element: document.getElementById("card-notes"),
                                intro: "Here you can see all notes for current job/task",
                                position: "right",
                            },
                            {
                                element: document.getElementById("card-mark"),
                                intro: "After you job has been completed, you have to estimate it. Minimum is 10%, Maximum - 100%. Remember, nobody knows, your diligence, your efforts better than you do.",
                                position: "right",
                            },
                            {
                                element: document.getElementById("card-mark"),
                                intro: "So, be honest with yourself! Your mark is only your decision. Anyway, your rate doesn`t(!) depend on it but grades would show you how good you were",
                                position: "right",
                            },
                        ],
                    })
                    .onafterchange(() => {
                        const currentStepIndex = introJS._currentStep;
                        const lastStepIndex = introJS._introItems.length - 1;

                        const getTimer = () => {
                            const getCurrentStepTimer = (step) => { //менять время показа каждого слайда
                                switch (step) {
                                    case 0:
                                        return 25000;
                                    case 1:
                                        return 19000;
                                    case 2:
                                        return 19000;
                                    case 3:
                                        return 27000;
                                    case lastStepIndex:
										return 27000;
                                    default: 
                                        return 19000;
                                }
                            };

                            const timerId = setTimeout(() => {
                                currentStepIndex < lastStepIndex ? introJS.nextStep() : introJS.exit();
                            }, getCurrentStepTimer(currentStepIndex));

                            setTimeout(() => {
                                const tooltipButtons = document.querySelector(".introjs-tooltip").querySelectorAll('a[role="button"]');

                                for (const button of tooltipButtons) {
                                    button.addEventListener("click", () => clearTimeout(timerId));
                                }
                            }, 0);
                        };

						getTimer();
                    }).onbeforeexit(() => {
						axios.post('/updateEduStep', {
                     		newStep: ++currentEduStep,
			         	})
					}).start();
            }
        } catch (error) {
            console.error(error);
        }
    },

    beforeDestroy() {
        window.removeEventListener('resize', this.updateScreenWidth);
    },
};
</script>
<style>
.v-card-actions {
    margin-top: -20px;
}
.v-card-title {
    background-color: #a10000;
    color: white;
}

</style>
