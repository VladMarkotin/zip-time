<template>
    <v-tooltip right>
        <template v-slot:activator="{ on: tooltip  }">
            <v-btn 
            v-on="tooltip"
            :size="buttonSize"
            @click="$emit('addSubtask')"
            icon
            >
                <v-icon 
                md="1" 
                :size="buttonSize - 12"
                color="#D71700" 
                > 
                    {{ icon.mdiPlex }}
                </v-icon>
            </v-btn>
        </template>
        <span>{{tooltip}}</span>
    </v-tooltip>
</template>

<script>
import {mdiPlex}  from '@mdi/js' 
export default {
        props: {
            buttonSize: {
                type: Number,
                default: 36,
            },
            tooltip: {
                type: String,
                default: 'Add subtask'
            },
        },
        data() {
            return {
                icon: {mdiPlex},
            }
        }
    }
</script>