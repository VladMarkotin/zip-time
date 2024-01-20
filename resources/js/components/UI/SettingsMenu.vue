<template>
    <v-menu
    bottom
    right
    >
        <template v-slot:activator="{ on,}">
            <v-btn
            dark
            v-on="on"
            icon
            >
                <v-icon color="black">{{icon.mdiCog}}</v-icon>
            </v-btn>
        </template>

        <v-list>
            <v-list-item
            v-for="(option, index) in options"
            link
            :key="index"
            >
                <v-list-item-title 
                class="option"
                @click="selectOption(option)"
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