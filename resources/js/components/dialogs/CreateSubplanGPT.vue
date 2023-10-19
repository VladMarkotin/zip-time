<template>
    <v-dialog 
    v-model="showDialog"
    overlay-color="transparent"
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
        font-family: 'Familjen Grotesk', sans-serif;
    }

    .subpan-GPT-text {
        font-weight: 500;
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
        align-items: flex-start;
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
        
    }

    .subpan-GPT-modal .subplan-gpt-footer > .subplan-gpt-footer-inner {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
</style>