<template>
    <v-tooltip 
	left 
	>
		<template v-slot:activator="{on}">
		    <v-btn 
		    icon 
			v-on="on" 
			v-on:click="$emit('click')"
			:disabled="isCommentEdited"
			>
				<v-icon color="#D71700" :size="iconSize"> {{icon.mdiPencil}} </v-icon>
			</v-btn>
		</template>
		<span>Edit comment</span>
	</v-tooltip>
</template>

<script>
    import {mdiPencil,} from '@mdi/js'
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
                icon: {mdiPencil},
            }
        }
    }
</script>