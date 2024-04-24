<template>
    <v-tooltip 
	right
	>
		<template v-slot:activator="{on}">
			<v-btn 
			icon 
			v-on="on" 
			v-on:click="$emit('click')"
			:disabled="!isCommentEdited"
			>
				<v-icon color="#D71700" :size="iconSize"> {{icon.mdiContentSaveMoveOutline }} </v-icon>
			</v-btn>
		</template>
		<span>Save comment</span>
	</v-tooltip>
</template>

<script>
    import {mdiContentSaveMoveOutline } from '@mdi/js'
    export default {
        props: {
            isCommentEdited: {
                type: Boolean,
                required: true,
            },
            iconSize: {
                type: Number,
                default: 29,
            }
        },
        data() {
            return {
                icon: {mdiContentSaveMoveOutline},
            }
        }
    }
</script>