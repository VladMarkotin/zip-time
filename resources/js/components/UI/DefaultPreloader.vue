<template>
     <v-progress-circular 
    indeterminate
    :color="color"
    :size="size"
    :width="width"
    ></v-progress-circular>
</template>

<script>
    export default {
        props: {
            color: {
                type: String,
                default: '#A10000',
            },

            size: {
                type: Number,
                default: 48,
            },

            width: {
                type: Number,
                default: 5,
            },
        }
    }
</script>