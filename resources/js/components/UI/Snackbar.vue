<template>
    <v-snackbar 
    :value="value" 
    @input="updateValue"
    :timeout="null"
    >
        {{text}}
    </v-snackbar>
</template>

<script>
    export default {
        props: {
            value: {
                type: Boolean,
                default: false,
            },
            text: {
                type: String,
                default: '',
            }
        },
        methods: {
            updateValue(value) {
                this.$emit('input', value);
            }
        }
    }
</script>