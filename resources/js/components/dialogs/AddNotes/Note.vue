<template>
    <v-card
    style="width: 100%;"
    >
        <v-row class="p-3 m-0">
            <v-col class="p-0 m-0 d-flex justify-content-between align-items-center" style="width: 100%;">
                <v-card-title class="p-0 m-0">
                    Note from {{ item.created_at }}
                </v-card-title>
                <!-- <DeleteButton 
                :tooltipValue = "'delete note'"
                @delete       = "deleteNote(item.id)"
                /> -->
            </v-col>
        </v-row>
            <v-card-text class="bg-white text--primary">
                <b>
                    {{ item.note }}
                </b>
            </v-card-text>
            <v-divider v-if="item.created_at == new Date('d.m.Y')"></v-divider>
    </v-card>
</template>

<script>
    export default {
        props: {
            item: {
                type: Object,
                required: true,
            },
        },
    }
</script>