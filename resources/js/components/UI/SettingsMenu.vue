<template>
    <v-menu
    bottom
    right
    :attach="attachTo ? `#${attachTo}` : false"
    >
        <template v-slot:activator="{ on,}">
            <v-btn
            icon
            v-on="on"
            >
                <v-icon color="black">{{icon.mdiCog}}</v-icon>
            </v-btn>
        </template>

        <v-list>
            <v-list-item
            v-for="(option, index) in options"
            link
            :key="index"
            @click="selectOption(option)"
            >
            <v-list-item-title 
            class="option"
                >
                    {{ option.title }}
                </v-list-item-title>
            </v-list-item>
      </v-list>
    </v-menu>
</template>

<script>
import { mdiCog } from '@mdi/js';
    export default {
        props: {
            item: {
                type: Object,
                required: true,
            },
            options: {
                type: Array,
            },
            attachTo: {
                type: String,
            }
        },
        data() {
            return {
                icon : {mdiCog},
            }
        },
        methods: {
            selectOption(option) {
                const event = option.event;
                const id    = this.item.id
                
                this.$emit(event, id);
            }
        },
    }
</script>

<style scoped>
    .option {
        cursor: pointer;
    }
</style>