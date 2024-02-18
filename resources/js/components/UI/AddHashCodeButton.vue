<template>
    <div class="add-hashCode-button p-0">
        <v-tooltip v-bind="tooltipPosition">
            <template v-slot:activator="{ on: tooltip  }">
                <v-btn 
                icon 
                v-on="tooltip"
                :size="buttonSize"
                >
                    <v-icon 
                    md="1"
                    :color="buttonColor"
                    @click="$emit('addHashCodeButtonClick')"
                    :size="buttonSize ? buttonSize : ''"
                    > 
                        {{icon.mdiPlusBox}}
                    </v-icon>
                </v-btn>
            </template>
            <span>Add hash-code to task for quick access</span>
        </v-tooltip>
    </div>
</template>

<script>

import {mdiPlusBox,} from '@mdi/js'
    export default {
        props: {
            buttonColor: {
                default: '#D71700',
            },

            buttonSize: {
            },

            tooltipPosition: {
                type: Object,
                default: () => ({ right: true }) 
            }
        },
        data: () => ({
            icon: {mdiPlusBox,},
        }),
    }
</script>

<style scoped>
    .add-hashCode-button {
        position: relative;
    }
</style>