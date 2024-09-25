<template>
    <v-card
    style="width: 100%;"
    class="p-3 note_note-card-wrapper"
    >
        <v-row class="p-0 m-0">
            <v-col 
            class="p-0 m-0 d-flex justify-content-between align-items-center" 
            style="width: 100%;"
            :id="getVMenuWrapperId(noteData.id)"
            >
                <v-card-title class="p-0 m-0 note_note-card-title">
                    Note from {{ noteData.created_at }}
                </v-card-title>
                <SettingsMenu 
                :item        =  "noteData"
                :options     =  "options"
                :attachTo    = "getVMenuWrapperId(noteData.id)"
                @deleteNote         = "deleteNote"
                @showEditNotesDialog = "showEditNotesDialog"
                />
            </v-col>
        </v-row>
        <v-card-text class="bg-white text--primary p-0 m-0">
            <b style="white-space: pre-line;">
                {{ noteData.note }}
            </b>
        </v-card-text>
    </v-card>
</template>

<script>
import SettingsMenu from '../../UI/SettingsMenu.vue';
    export default {
        props: {
            noteData: {
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
        emits: ['deleteNote', 'showEditNotesDialog'],
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