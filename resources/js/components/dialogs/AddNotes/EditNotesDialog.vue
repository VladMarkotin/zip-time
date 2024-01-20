<template>
    <v-dialog 
    width="450" 
    v-model="showEditNoteDialog"
    >
        <v-card class="m-0">
            <v-row class="py-2 px-8 m-0 d-flex justify-content-start align-items-center">
                <ResetButton 
                :disabled="!isNoteTextChanged"
                @reset="resetNoteInputVal"
                />
            </v-row>
            <v-row class="py-2 px-8 m-0">
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
                <v-btn
                @click="closeEditNotesDialog"
                >
                    Cancel
                </v-btn>
                <v-btn
                :disabled="!isEditableNoteInpuValValid"
                @click="saveChangesInNote"
                >
                    Save
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import ResetButton from '../../UI/ResetButton.vue';
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
                isNoteTextChanged: false,
            }
        },

        components: {
            ResetButton,
        },

        watch: {
            showEditNoteDialog(dialogStatus) {
                if (dialogStatus === false) this.closeEditNotesDialog();
            }
        },

        methods: {
            checkEditableNoteInputVal() {
                this.checkIsInputValValid();
                this.chekisNoteTextChanged();
            },

            chekisNoteTextChanged() {
                const oldText = this.editableNoteData.note;
                this.isNoteTextChanged = oldText !== this.editableNoteInputVal;
            },

            checkIsInputValValid() {
                this.isEditableNoteInpuValValid = 
                this.noteRules.map(check => check(this.editableNoteInputVal))
                .every(checkResult => checkResult === true);
            },

            resetNoteInputVal() {
                this.editableNoteInputVal = this.editableNoteData.note;
                this.isNoteTextChanged = false;
                this.isEditableNoteInpuValValid = true;
            },

            closeEditNotesDialog() {
                this.$emit('closeEditNotesDialog');
            },

            saveChangesInNote() {
                const {id} = this.editableNoteData;
                const note = this.editableNoteInputVal;

                this.$emit('editNote', {id, note});
                this.closeEditNotesDialog();
            }
        }
    }
</script>