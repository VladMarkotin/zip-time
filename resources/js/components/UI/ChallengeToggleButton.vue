<template>
    <v-btn 
    v-on:click="$emit('toggleDispChallenges')"
    outlined
    color="red"
    large
    >
		{{ buttonText.get(showChallenges) }}
	</v-btn>
</template>

<script>
    export default {
        props: {
            showChallenges: {
                type: Boolean,
                required: true,
            }
        },
        data() {
            return {
                buttonText: new Map([
                    [true, 'Close my Challenges'],
                    [false, 'Show my Challenges']
                ]),
            }
        }
    }
</script>