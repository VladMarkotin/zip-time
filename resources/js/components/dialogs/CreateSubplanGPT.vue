<template>
    <v-dialog 
    v-model="showDialog"
    content-class="subpan-GPT-modal"
    width="477"
    >
        <template v-slot:activator="{ on }">
            <div>
                <v-btn 
                id="subplan-GPT-button"
                color="rgb(255, 255, 255)"
                elevation
                @click="toggleDialog"
                >
                    <v-icon size="28">$vuetify.icons.chatGPTIcon</v-icon>
                </v-btn>
            </div>
        </template>
        <CreateSubplanGPTCard 
        v-if="showDialog"
        :requestData="requestData"
        @toggleDialog="toggleDialog"
        />
    </v-dialog>
</template>

<script>
    import CreateSubplanGPTCard from './CreateSubplanGPTCard.vue';
    export default {
       props: ['requestData'],
       data() {
            return {
                showDialog: false,
            }
       },
       components: {CreateSubplanGPTCard},
       methods: {
            toggleDialog() {
                this.showDialog = !this.showDialog;
            },
       },
    }
</script>

<style>
    #subplan-GPT-button,
    #subplan-GPT-button-modal,
    #subplan-GPT-button-playoutline,
    #subplan-GPT-button-cogrefresh {
        padding: 0 .3em;
        min-width: 0;
        border-radius: 50%;
    }

    #sublpan-gpt-button-recreate {
        padding:  0 .3em 0 .6em;
        min-width: 0;
        border-radius: 50%;
    }

    .subpan-GPT-modal .subplan-gpt-disabled-button {
        opacity: .5;
    }

    .subpan-GPT-modal {
        box-shadow: none !important;
        /* font-family: 'Familjen Grotesk', sans-serif; */
    }

    .subpan-GPT-text {
        font-weight: 500;
        font-size: 15px;
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
        padding: 16px 24px;
        display: flex;
        gap: 30px;
        align-items: center;
    }

    .subpan-GPT-modal .subplan-GPT-title {
        color: #C80000;
        margin-bottom: 0;
        padding: 0;
        font-size: 1.15rem;
    }

    .subpan-GPT-modal .subplan-GPT-input-wrapper {
        padding: 0 24px;
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
        height: 350px;
        padding: 16px 24px;
        align-items: flex-start;
        box-sizing: border-box;
        overflow: scroll;
    }
    
    .subplan-gpt-subtasks-list-wrapper::-webkit-scrollbar {
        width: 12px;
    }

    .subplan-gpt-subtasks-list-wrapper::-webkit-scrollbar-thumb {
        background: #b0b0b0;
        border: solid 3px #e6e6e6;
        border-radius: 7px;
    }

    .subplan-gpt-subtasks-list-wrapper::-webkit-scrollbar-thumb:hover {
        background: rgb(161, 0, 0);
    }

    .subpan-GPT-modal .subplan-gpt-subtasks-list {
        animation: 1.5s subtasklistappearance ease;
        overflow: hidden;
    }

    .subpan-GPT-modal .subplan-gpt-subtasks-list .subplan-gpt-subtasks-li {
        padding: 0;
    }

    .subpan-GPT-modal .subplan-gpt-subtasks-list .subplan-gpt-subtasks-li:not(:last-child) {
        margin-bottom: 4px;
    }

    .subpan-GPT-modal div[role="listitem"].subplan-gpt-footer {
        min-height: 40px;
        background-color: #FAFAFA;
        padding: 16px 24px;
    }

    .subpan-GPT-modal .subplan-gpt-footer > .subplan-gpt-footer-inner {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    @keyframes subtasklistappearance {
        from {
            opacity: 0;
            max-height: 0;
        }
        to {
            opacity: 1;
            max-height: 1200px;
        } 
    }

    @import url('/css/CreateSubplanGPT/CreateSubplanGPTMedia.css');
</style>