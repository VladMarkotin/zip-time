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
                        ref="test"
                        ></v-text-field>
                    </v-list-item>
                    <v-btn 
                    color="rgb(255, 255, 255)"
                    elevation
                    id="sublpan-gpt-button-recreate"
                    :class="!isTaskNameValid ? 'subplan-gpt-disabled-button' : ''"
                    :disabled="!isTaskNameValid"
                    >
                        <v-icon size="18">$vuetify.icons.gptRecreateIcon</v-icon>
                    </v-btn>
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
                <v-list-item class="subplan-gpt-footer"></v-list-item>
            </v-list>
        </v-card>
</template>

<script>
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
                isTaskNameValid: false,
                isLoading: false,
                subtasksFromChatGPT: [],
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

            checkTaskNameValue() { //проверяю,что все проверки для значения из инпута с названием таски прошли успешно
                this.isTaskNameValid = this.taskNameRules.map(check => {
                    return check(this.taskName);
                }).every(currentVal => currentVal === true)
            },

            getSubTasks() {
                this.isLoading = true;
                setTimeout(() => {
                    this.subtasksFromChatGPT = [
                        'subtask one',
                        'subtask two',
                        'subtask three',
                    ]
                    this.isLoading = false;
                },1000)
            },

            getSubTaskLi(subtask, index) {
                return `${index + 1}) ${subtask}`;
            },
        },

        mounted() {
            this.$refs.test.validate(true)
            this.checkTaskNameValue();
            if (this.isTaskNameValid) this.getSubTasks();
        }
    }
</script>