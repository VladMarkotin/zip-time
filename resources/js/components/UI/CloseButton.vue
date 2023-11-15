<template>
    <v-tooltip right>
		<template v-slot:activator="{on}">
			<v-btn icon v-on="on" v-on:click="$emit('close')">
				<v-icon color="#D71700" large>{{icon.mdiCancel}}</v-icon>
			</v-btn>
		</template>
		<span>Cancel</span>
	</v-tooltip>
</template>

<script>
import {mdiCancel} from '@mdi/js';
    export default {
        props: {
            tooltipText: {
                default: 'Cancel',
            }
        },
        data() {
            return {
                icon: {mdiCancel},
            }
        }
    }
</script>