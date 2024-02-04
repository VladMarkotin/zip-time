<template>
    <v-tooltip v-bind="tooltipPosition">
		<template v-slot:activator="{on}">
			<v-btn icon v-on="on" v-on:click="$emit('clearCurrentHashCode')">
				<v-icon color="#D71700">{{icon.mdiBackspace}}</v-icon>
			</v-btn>
		</template>
		<span>{{ tooltipText }}</span>
	</v-tooltip>
</template>

<script>
import {mdiBackspace} from '@mdi/js';
    export default {
        props: {
            tooltipText: {
                default: 'Clear current hash code',
            },

            tooltipPosition: {
                type: Object,
                default: () => ({ right: true }) 
            }
        },
        data() {
            return {
                icon : {mdiBackspace},
            }
        }
    }
</script>