<template>
    <v-card
    style="width: 100%;"
    class="p-3 note_note-card-wrapper"
    >
        <v-row class="p-0 m-0">
            <v-col 
            class="p-0 m-0 d-flex justify-content-between align-items-center" 
            style="width: 100%;"
            :id="getVMenuWrapperId(item.id)"
            >
                <v-card-title class="p-0 m-0 note_note-card-title">
                    Note from {{ item.created_at }}
                </v-card-title>
                <SettingsMenu 
                :item     =  "item"
                :options  =  "options"
                :attachTo = "getVMenuWrapperId(item.id)"
                @deleteNote         = "deleteNote"
                @showEditNotesDialog = "showEditNotesDialog"
                />
            </v-col>
        </v-row>
        <v-card-text class="bg-white text--primary p-0 m-0">
            <b style="white-space: pre-line;">
                {{ item.note }}
            </b>
        </v-card-text>
    </v-card>
</template>

<script>
import SettingsMenu from '../../UI/SettingsMenu.vue';
    export default {
        props: {
            item: {
                type: Object,
                required: true,
            },
        },

        data() {
            return {
                options: [
                    {title: 'remove', event: 'deleteNote'},
                    {title: 'edit', event: 'showEditNotesDialog'},
                ],
            }
        },

        components: {
            SettingsMenu
        },

        methods: {
            deleteNote(id) {
                this.$emit('deleteNote', id);
            },

            showEditNotesDialog(id) {
                this.$emit('showEditNotesDialog', id);
            },

            getVMenuWrapperId(id) {
                return `v_menu_wrapper_${id}`;
            }
        },
    }
</script>

<style>
@import url('/css/Note/NoteMedia.css');
</style>