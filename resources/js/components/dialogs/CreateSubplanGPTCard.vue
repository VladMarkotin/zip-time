<template>
   <v-card>
            <v-list>
                <v-list-item class="subplan-GPT-header">
                    <v-btn
                    id="subplan-GPT-button-modal"
                    color="#EFEFEF"
                    elevation
                    @click="toggleDialog"
                    >
                        <v-icon size="28">$vuetify.icons.chatGPTIcon</v-icon>
                    </v-btn>
                    <v-card-title class="subplan-GPT-title subpan-GPT-text">Create subplan with ChatGPT</v-card-title>
                </v-list-item>
                <v-list-item class="subplan-GPT-input-wrapper">
                    <v-list-item class="subplan-GPT-input-inner">
                        <v-card-text class="subpan-GPT-text"><label for="subplan-GPT-taskname-input">{{ requestData.label }}</label></v-card-text>
                        <v-text-field
                        v-model="taskName"
                        id="subplan-GPT-taskname-input"
                        placeholder="current task name"
                        color="#000000"
                        :rules="taskNameRules"
                        required
                        ref="taskNameInput"
                        success
                        ></v-text-field>
                    </v-list-item>
                    <v-tooltip right>
						<template v-slot:activator="{on}">
                    <v-btn 
                    v-on="on"
                    color="rgb(255, 255, 255)"
                    elevation
                    id="sublpan-gpt-button-recreate"
                    :class="!isTaskNameValid ? 'subplan-gpt-disabled-button' : ''"
                    :disabled="!isTaskNameValid"
                    @click="sendGPTRequest()"
                    >
                        <v-icon size="18">$vuetify.icons.gptRecreateIcon</v-icon>
                    </v-btn>
                </template>
                <span>Ask chatGPT for help</span>
                    </v-tooltip>
                </v-list-item>
                <v-divider></v-divider>
                <v-list-item class="subplan-gpt-subtasks-list-wrapper">
                    <v-list-item-content v-if="isLoading">
                        <v-progress-circular 
                        indeterminate
                        color="#A10000"
                        size="48"
                        width="5"
                        ></v-progress-circular>
                    </v-list-item-content>
                    <v-list-item-content v-else-if="subtasksFromChatGPT.length == 0 && isLoading == false">
                        {{ subtasksFromChatGPTWelcome }}
                    </v-list-item-content>
                    <v-list v-else class="subplan-gpt-subtasks-list">
                        <v-list-item-content
                        v-for="(subtask, index) in subtasksFromChatGPT"
                        :key="index"
                        class="subplan-gpt-subtasks-li subpan-GPT-text"
                        >
                        {{ getSubTaskLi(subtask, index) }}
                    </v-list-item-content>
                    </v-list>
                </v-list-item>
                <v-divider></v-divider>
                <v-list-item class="subplan-gpt-footer">
                    <div class="subplan-gpt-footer-inner">
                        <v-tooltip right>
						<template v-slot:activator="{on}">
                           <v-btn
                                v-on="on"
                                color="#FAFAFA"
                                elevation
                                id="subplan-GPT-button-playoutline"
                                @click="createSubPlanViaGPT()"
                            >
                            <v-icon size="30">{{ icons.mdiPlayOutline }}</v-icon>
                        </v-btn>
                        </template>
                        <span>Save and add subplan</span>
                        </v-tooltip>
                        <v-tooltip right>
						<template v-slot:activator="{on}">
                        <v-btn
                        color="#FAFAFA"
                        v-on="on"
                        elevation
                        id="subplan-GPT-button-cogrefresh"
                        >
                            <v-icon size="30">{{ icons.mdiCogRefresh }}</v-icon>
                        </v-btn>
                        </template>
                        <span>Regenerate GPT`s answer</span>
                        </v-tooltip>
                    </div>
                </v-list-item>
            </v-list>
        </v-card>
</template>

<script>
    import { mdiPlayOutline, mdiCogRefresh } from '@mdi/js';
    export default {
        props: ['requestData'],
        data() {
            return {
                taskName: this.requestData.taskName,
                taskNameRules: [
                    (v) => {
                        return v.trim().length > 2 || 'Minimum length is 3 characters'
                    },

                    (v) => {
                        return !v.match(/^\d*$/) || 'can\'t consist only of numbers';
                    }
                ],
                taskHash: this.requestData.taskHash,
                taskId: this.requestData.taskId,
                isTaskNameValid: false,
                isLoading: false,
                subtasksFromChatGPT: [],
                subtasksFromChatGPTWelcome: "Create Your SubPlan with charGPT!",
                icons: {
                    mdiPlayOutline,
                    mdiCogRefresh
                }
            }
        },
        watch: {
            taskName() {
                this.checkTaskNameValue();
            }
        },
        methods: {
            toggleDialog() {
                this.$emit('toggleDialog');
            },

            sendGPTRequest() {
                if (this.taskName.length > 1) { 
                    axios.post('/create-gpt-subplan-request',{request: this.taskName,
                         taskId: this.taskId, 
                        hash: this.taskHash                        
                        })
                        .then((response) => {
                            this.isLoading = true
                            setTimeout( () => {
                                    this.isLoading = false
                            },3000)
                            this.subtasksFromChatGPT = []
                            this.subtasksFromChatGPT.push('task1')
                            this.subtasksFromChatGPT.push('task2')
                        }
                    )
                } else {

                }
            },

            createSubPlanViaGPT() {
                if (this.subtasksFromChatGPT.length > 0) {

                    setTimeout( () => {
                                        this.isLoading = false
                                },3000)
                    axios.post('/create-gpt-subplan',{plan: this.subtasksFromChatGPT,
                        taskId: this.taskId, 
                        hash: this.taskHash 
                        })
                            .then((response) => {
                                this.isLoading = true
                                
                                this.subtasksFromChatGPT = []
                                this.subtasksFromChatGPTWelcome = "SubPlan has been succesfully created. Whish you good luck:)"
                            }
                        )
                }
            },

            checkTaskNameValue() { //проверяю,что все проверки для значения из инпута с названием таски прошли успешно
                this.isTaskNameValid = this.taskNameRules.map(check => {
                    return check(this.taskName);
                }).every(currentVal => currentVal === true)
            },

            getSubTasks() {
                this.isLoading = true;
                setTimeout(() => {
                    this.subtasksFromChatGPT = [
                        
                    ]
                    if (!this.subtasksFromChatGPT.length) {
                        
                        
                    }
                    this.isLoading = false;
                },1000)
            },

            getSubTaskLi(subtask, index) {
                return `${index + 1}) ${subtask}`;
            },
        },

        mounted() {
            this.$refs.taskNameInput.validate(true)
            this.checkTaskNameValue();
            if (this.isTaskNameValid) this.getSubTasks();
        }
    }
</script>