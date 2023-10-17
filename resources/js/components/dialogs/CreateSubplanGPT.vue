<template>
    <v-dialog 
    v-model="showDialog"
    hide-overlay
    content-class="chatGPT-modal"
    >
        <template v-slot:activator="{ on }">
            <v-btn 
            class="position-absolute top-0 end-0"
            id="chatGPT-button"
            color="rgb(255, 255, 255)"
            elevation
            @click="toggleDialog"
            >
                <v-icon size="28">$vuetify.icons.chatGPTIcon</v-icon>
            </v-btn>
        </template>
        <v-card>
            <v-card-title>Hello</v-card-title>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
       data() {
        return {
            showDialog: false,
        }
       },

       methods: {
        toggleDialog() {
            this.showDialog = !this.showDialog;
        },
       }
    }
</script>

<style scoped>
    #chatGPT-button {
        padding: 0 .3em;
        min-width: 0;
        border-radius: 50%;
    }

    #chatGPT-button .v-icon__component {
        background-color: orange;
    }

    
</style>