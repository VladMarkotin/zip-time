<template>
    <v-tooltip right>
        <template v-slot:activator="{ on: tooltip  }">
            <v-btn 
            v-on="tooltip"
            icon 
            @click.stop="$emit('click')">
                <v-icon color="#D71700">{{ icon.mdiPencil }}</v-icon>
            </v-btn>
        </template>
        <span>{{ tooltipValue }}</span>
    </v-tooltip>
</template>

<script>
import {mdiPencil }  from '@mdi/js' 
    export default {
        props: {
            tooltipValue: {
                type: String,
                default: 'Edit',
            }
        },
        data() {
            return {
                icon: {mdiPencil,},
            }
        }
    }
</script>