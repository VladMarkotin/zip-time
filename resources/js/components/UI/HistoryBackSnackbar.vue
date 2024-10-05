<template>
    <v-snackbar 
    :value="true" 
    :timeout="null"
    color="rgb(161, 0, 0)"
    content-class="history-back-snackbar"
    @click="goBack"
    >
        Have you planned all your tasks?
        <template v-slot:action>
            <v-btn @click="goBack" text>Yes</v-btn>
        </template>
    </v-snackbar>
</template>

<script>
    export default {
        data() {
                return {
                    clickCount: 0,
                };
            },
        methods: {
            goBack() {
                this.clickCount++;
                if (this.clickCount <= 1) {
                    window.history.back();
                }
            }
        }
    }
</script>

<style scoped>
    ::v-deep .history-back-snackbar {
        text-align: center;
    }
</style>