<template>
    <v-dialog 
    v-model="showDialog"
    hide-overlay
    content-class="subpan-GPT-modal"
    width="477"
    >
        <template v-slot:activator="{ on }">
            <v-btn 
            class="position-absolute top-0 end-0"
            id="subplan-GPT-button"
            color="rgb(255, 255, 255)"
            elevation
            @click="toggleDialog"
            >
                <v-icon size="28">$vuetify.icons.chatGPTIcon</v-icon>
            </v-btn>
        </template>
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
                        ></v-text-field>
                    </v-list-item>
                    <v-btn 
                    color="rgb(255, 255, 255)"
                    elevation
                    id="sublpan-gpt-button-recreate"
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
                        v-for="(item, index) in subtasksFromChatGPT"
                        :key="index"
                        class="subplan-gpt-subtasks-li subpan-GPT-text"
                        >
                        1
                    </v-list-item-content>
                    </v-list>
                </v-list-item>
            </v-list>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
       props: ['requestData'],
       data() {
            return {
                taskName: this.requestData.taskName,
                showDialog: false,
                taskNameRules: [
                    (v) => v.trim().length > 0 || 'Minimum length is 3 characters',
                ],
                isLoading: false,
                subtasksFromChatGPT: [],
            }
       },
       methods: {
        toggleDialog() {
            this.showDialog = !this.showDialog;
            if (this.showDialog) {
                this.taskName = this.requestData.taskName;
                this.getTasks();
            }
        },

        getTasks() {
            this.isLoading = true;
            setTimeout(() => {
                this.subtasksFromChatGPT = [
                    'subtask one',
                    'subtask two',
                    'subtask three',
                ]
                this.isLoading = false;
            },1000)
        }
       },

       mounted() {
        this.getTasks();
       }
    }
</script>

<style>
    #subplan-GPT-button,
    #subplan-GPT-button-modal {
        padding: 0 .3em;
        min-width: 0;
        border-radius: 50%;
    }

    #sublpan-gpt-button-recreate {
        padding:  0 .3em 0 .6em;
        min-width: 0;
        border-radius: 50%;
    }

    .subpan-GPT-modal {
        box-shadow: none !important;
        font-family: 'Familjen Grotesk', sans-serif;
    }

    .subpan-GPT-text {
        font-weight: 400;
        font-size: 16px;
        line-height: 20px;
        vertical-align: middle;
    }

    .subpan-GPT-modal .v-card {
        border: 1px solid #BEBEBE;
    }

    .subpan-GPT-modal div[role="list"] {
        padding: 0;
    }

    .subpan-GPT-modal div[role="listitem"] {
        min-height: 0;
    }

    .subpan-GPT-modal hr[role="separator"] {
        margin: 0;
    }

    .subpan-GPT-modal .v-card .subplan-GPT-header {
        background-color: #EFEFEF;
        gap: 53px;
        padding: 7px 14px 5px;
    }

    .subpan-GPT-modal .subplan-GPT-title {
        color: #C80000;
        margin-bottom: 0;
        padding: 0;
    }

    .subpan-GPT-modal .subplan-GPT-input-wrapper {
        padding: 0 15px;
        justify-content: space-between;
    }

    .subpan-GPT-modal .subplan-GPT-input-wrapper .subplan-GPT-input-inner {
        padding: 0;
        gap: 14px;
    }

    .subpan-GPT-modal .subplan-GPT-input-wrapper .v-card__text {
        padding: 0;
        color: #000000;
        width: auto;
    }

    .subpan-GPT-modal .subplan-GPT-input-wrapper .v-text-field {
        margin-top: 0;
        max-width: 40%;
    }

    .subpan-GPT-modal div[role="listitem"].subplan-gpt-subtasks-list-wrapper {
        min-height: 135px;
        padding: 9px 16px;
    }

    .subpan-GPT-modal .subplan-gpt-subtasks-list {
        height: 100%;
    }

    .subpan-GPT-modal .subplan-gpt-subtasks-list .subplan-gpt-subtasks-li {
        padding: 0;
    }
</style>