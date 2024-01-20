<template>
    <v-dialog 
    width="450" 
    v-model="showEditNoteDialog"
    >
        <v-card class="m-0">
            <v-row class="py-4 px-8 m-0">
                <v-col class="p-0 m-0">
                    <v-textarea
                    v-model="editableNoteInputVal"
                    outlined 
                    counter="256" 
                    no-resize
                    rows="3"
                    :rules = "noteRules"
                    :success = "isEditableNoteInpuValValid"
                    clearable
                    @input="checkEditableNoteInputVal"
                    >
        
                    </v-textarea>
                </v-col>
            </v-row>
            <v-divider class="mt-2 mb-2"></v-divider>
            <v-card-actions class="py-1 px-8 m-0 d-flex justify-content-between align-items-center">
                <v-btn>Reset</v-btn>
                <v-btn>Save</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        props: {
            isShowEditNotesDialog: {
                type: Boolean,
                required: true,
            },

            editableNoteData: {
                type: Object,
                required: true,
            },

            noteRules: {
                type: Array,
            },
        },
        data() {
            return {
                showEditNoteDialog: this.isShowEditNotesDialog,
                editableNoteInputVal: this.editableNoteData.note,
                isEditableNoteInpuValValid: true,
            }
        },

        watch: {
            showEditNoteDialog(dialogStatus) {
                if (dialogStatus === false) this.$emit('closeEditNotesDialog');
            }
        },

        methods: {
            checkEditableNoteInputVal() {
                this.isEditableNoteInpuValValid = 
                this.noteRules.map(check => check(this.editableNoteInputVal))
                .every(checkResult => checkResult === true);
            },
        }
    }
</script>