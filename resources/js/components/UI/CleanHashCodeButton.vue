<template>
    <v-tooltip right>
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
            }
        },
        data() {
            return {
                icon : {mdiBackspace},
            }
        }
    }
</script>