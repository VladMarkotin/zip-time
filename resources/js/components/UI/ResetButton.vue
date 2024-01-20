<template>
    <v-tooltip right>
		<template v-slot:activator="{on}">
			<v-btn 
            icon 
            :disabled="disabled"
            @click="$emit('reset')"
            v-on="on"
            >
				<v-icon color="black" large>{{icon.mdiReload}}</v-icon>
			</v-btn>
		</template>
		<span>{{tooltipText}}</span>
	</v-tooltip>
</template>

<script>
import {mdiReload} from '@mdi/js';
    export default {
        props: {
            tooltipText: {
                default: 'Reset',
            },
            disabled: {
                type: Boolean,
                default: false,
            }
        },
        data() {
            return {
                icon: {mdiReload},
            }
        }
    }
</script>