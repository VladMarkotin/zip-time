<template>
    <v-card
	width="450"
    class="pt-6 pb-6 addNotes-addNotesCard-wrapper"
    >
		<v-card-title class="pt-0 addNotesCard-title">Notes list</v-card-title>
		<v-divider class="mt-2 mb-2"></v-divider>
        <v-row class="m-0">
            <v-col class="p-0 m-0">
                <v-expansion-panels>
                    <v-expansion-panel>
                        <v-expansion-panel-header class="addNotesCard-accordion-header">
                            <template v-slot:default="{ open }">
                                <v-row class="p-0 m-0" style="min-height: 36px;">
                                    <v-col class="p-0 m-0 d-flex justify-content-start d-flex align-items-center">         
                                        <p 
                                        v-if="open"
                                        class="m-0"
                                        >
                                            Close this menu
                                        </p>
                                        <p 
                                        v-else="open"
                                        class="m-0"
                                        >
                                            Add New Note
                                        </p>
                                    </v-col>
                                    <v-col class="p-0 m-0 d-flex justify-content-end d-flex align-items-center">
                                        <AddSubtaskButton 
                                        v-if="open && isNewNoteInpuValValid"
                                        :tooltip="'Add note'"
                                        @addSubtask="addNewNote"
                                        />
                                    </v-col>
                                </v-row>
                            </template>
                        </v-expansion-panel-header>
                        <v-expansion-panel-content style="padding: 0 16px;">
                            <div class="pt-2">
                                <v-textarea 
                                v-model="newNoteInpuVal"
                                outlined 
                                label="new note"
                                counter="256" 
                                no-resize
                                rows="3"
                                :rules = "noteRules"
                                :success = "isNewNoteInpuValValid"
                                clearable
                                @input="checkNewNoteInputVal"
                                >
                                </v-textarea>
                            </div>
                        </v-expansion-panel-content>
                    </v-expansion-panel>
                </v-expansion-panels>
            </v-col>
        </v-row>
		<v-divider class="mt-2 mb-2"></v-divider>
        <v-card-text 
        class="pb-0 addNotesCard-notes-wrapper"
        style="height: 450px; position: relative; overflow-x: hidden"
        >
            <v-list >
            <transition-group name="list" tag="div" class="notes-wrapper">
                <v-list-item v-for="(item, i) in notesList" :key="item.id" class="list-item">
                    <Note 
                    :item        = "item"
                    @deleteNote         = "deleteNote"
                    @showEditNotesDialog = "showEditNotesDialog"
                    />
                </v-list-item>
            </transition-group>
            </v-list>
        </v-card-text>
        <v-divider class="m-0"></v-divider>
		<v-card-actions 
        class="px-6 addNotesCard-footer addNotesCard-footer"
        >
        <v-row 
        class="d-flex justify-content-between align-items-end p-0 m-0"
        style="min-height: 72px;"
        >
            <v-col 
            class="p-0 m-0"
            style="width: 100%;"
            >
                <transition
                enter-active-class="custom-alert_appearance"
                leave-active-class="custom-alert_leave"
                >
                    <v-alert 
                    v-if="isShowAlert"
                    class="custom-alert addNotesCard-alert"
                    :type="alertData.type"
                    >
                        {{ alertData.text }}
                    </v-alert>
                </transition>
            </v-col>
            <v-col
            class="p-0 m-0 d-flex justify-content-end"
            cols="4"
            >
                <v-btn
                color="blue-darken-1"
                variant="text"
                class="close-button"
                @click="closeAddNotesDialog"
                >
                    Close
                </v-btn>        
            </v-col>
        </v-row>
		</v-card-actions>
        <template
        v-if="isShowEditNotesDialog"
        >
            <EditNotesDialog 
            :isShowEditNotesDialog = "isShowEditNotesDialog"
            :editableNoteData      = "editableNoteData"
            :noteRules             = "noteRules"
            @closeEditNotesDialog  = "closeEditNotesDialog"
            @editNote              = "editNote"
            />
        </template>
	</v-card>
</template>

<script>
import { mapGetters, mapActions } from 'vuex/dist/vuex.common.js';
import AddSubtaskButton from '../../UI/AddSubtaskButton.vue';
import Note from './Note.vue';
import EditNotesDialog from './EditNotesDialog.vue';
    export default {
        props: {
            item: {
                type: Object,
                required: true,
            },
            taskId: {
                type: Number,
                required: true,
            }
        },
        data() {
            return {
                isShowAlert: false,
                closeAlertTime: 0,
                showAlerTime: 1500, //менять время показа алерта
                alertData: {
                    type: '',
                    text: '',
                },
                newNoteInpuVal: '',
                isNewNoteInpuValValid: false,
                noteRules: [
                    (val) => {
                        const errorMessage = "Your note can't be empty";

                        if (!val) return errorMessage;
                        val = val.trim();
                        return val.length ? true : errorMessage;
                    },

                    (val) => {
                        let errorMessage = "Your note is too long";

                        if (!val) return "Your note can't be empty";
                        val = val.trim();
                        return val.length <= 256 ? true : errorMessage;
                    },
                ],
                isShowEditNotesDialog: false,
                editableNoteData: {},
            };
        },
        emits: ['closeAddNotesDialog'],
        computed: {
            ...mapGetters(['getNotesData']),
            notesList() {
                return this.getNotesData(this.taskId);
            }
        },
        components: {
            AddSubtaskButton,
            Note,
            EditNotesDialog,
        },

        methods: {
            ...mapActions(['addNote', 'removeNote', 'editCurrentNote']),
            async deleteNote(noteId) {
                try {
                    const response = await this.removeNote({taskId: this.taskId, noteId});
                    const respData = response.data;

                    this.setAlertData(respData);
                    this.showAlert();
                } catch (error) {
                    console.error(error);
                }
            },

            setAlertData({status, message}) {
                this.alertData = {
                    type: status,
                    text: message,
                };
            },

            showAlert() {
                this.isShowAlert = true;
                        
                clearTimeout(this.closeAlertTime);

                this.closeAlertTime = setTimeout(() => {
                    this.removeAlert();
                }, this.showAlerTime)
            },

            removeAlert() {
                this.isShowAlert = false;
                this.setAlertData('', '');
            },

            checkNewNoteInputVal() {
                this.isNewNoteInpuValValid = 
                this.noteRules.map(check => check(this.newNoteInpuVal))
                .every(checkResult => checkResult === true);
            },

            async addNewNote() {
                const taskId = this.taskId;
                const note    = this.newNoteInpuVal.trim();
                
                try {
                    const response = await this.addNote({taskId, note});
                    const respData = response.data;

                    if (respData.status === 'success') {
                        this.newNoteInpuVal = '';
                        this.isNewNoteInpuValValid = false;
                    }

                    this.setAlertData({status: respData.status, message: respData.text});
                    this.showAlert();
                } catch(error) {
                    console.error(error);
                }
            },

            showEditNotesDialog(id) {
                this.setEditableNoteData(id);
                this.isShowEditNotesDialog = true;
            },

            closeEditNotesDialog() {
                this.isShowEditNotesDialog = false;
            },

            closeAddNotesDialog() {
                this.$emit('closeAddNotesDialog');
            },

            setEditableNoteData(id) {
                const currenNote = this.notesList.find(note => note.id === id);
                this.editableNoteData = {...currenNote};
            },

            async editNote(updatedNote) {
                try {
                    const response = await this.editCurrentNote({taskId: this.taskId, updatedNote});
                    const respData = response.data;
                    
                    this.setAlertData({status: respData.status, message: respData.message});
                    this.showAlert();
                } catch(error) {
                    console.error(error);
                }
            }
        },

    }
</script>

<style scoped>
    .notes-wrapper {
        display: flex;
        flex-direction: column;
        gap: 30px;
    }
    
    .list-item {
        width: 100%;
    }
    .list-enter-active, .list-leave-active {
    transition: all .3s;
    }
    .list-enter, 
    .list-leave-to  {
    opacity: 0;
    transform: translateX(30px);
    }

    .custom-alert {
        margin-bottom: 0;
        position: relative;
    }

    .custom-alert_appearance {
        animation: .3s custom_alert_show ease;
    }

    .custom-alert_leave {
        animation: .3s custom_alert_leave ease;
    }

    @keyframes custom_alert_show {
		from { opacity: 0; left: -10px;}
		to { opacity: 1; left: 0;}
	}

	@keyframes custom_alert_leave {
		from { opacity: 1; left: 0;}
		to { opacity: 0; left: 10px;}
	}

    .addNotesCard-notes-wrapper::-webkit-scrollbar {
        width: 12px;
    }

    .addNotesCard-notes-wrapper::-webkit-scrollbar-track {
        background: #e6e6e6;
        border-left: 1px solid #dadada;
    }

    .addNotesCard-notes-wrapper::-webkit-scrollbar-thumb {
        background: #b0b0b0;
        border: solid 3px #e6e6e6;
        border-radius: 7px;
    }

    .addNotesCard-notes-wrapper::-webkit-scrollbar-thumb:hover {
        background: rgb(161, 0, 0);
        cursor: pointer;
    }

    @import url('/css/AddNotesCard/AddNotesCardMedia.css');
</style>