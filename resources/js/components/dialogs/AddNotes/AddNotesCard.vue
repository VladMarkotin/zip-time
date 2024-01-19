<template>
    <v-card
	width="450"
    >
		<v-card-title>Notes list</v-card-title>
		<v-divider class="mt-2 mb-2"></v-divider>
        <v-row class="m-0">
            <v-col class="p-0 m-0">
                <v-expansion-panels>
                    <v-expansion-panel>
                        <v-expansion-panel-header>
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
                            <!-- prepend-inner-icon="mdi-comment" -->
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
                        </v-expansion-panel-content>
                    </v-expansion-panel>
                </v-expansion-panels>
            </v-col>
        </v-row>
		<v-divider class="mt-2 mb-2"></v-divider>
        <v-card-text 
        class="pb-0"
        style="height: 450px; position: relative; overflow-x: hidden"
        >
            <v-list 
            v-if="!isLoading"
            >
            <transition-group name="list" tag="div" class="notes-wrapper">
                <v-list-item v-for="(item, i) in notesList" :key="item.id" class="list-item">
                    <v-card
                    style="width: 100%;"
                    >
                    <v-row class="p-3 m-0">
                        <v-col class="p-0 m-0 d-flex justify-content-between align-items-center" style="width: 100%;">
                            <v-card-title class="p-0 m-0">
                                Note from {{ item.created_at }}
                            </v-card-title>
                            <DeleteButton 
                            :tooltipValue = "'delete note'"
                            @delete       = "deleteNote(item.id)"
                            />
                        </v-col>
                    </v-row>
                        <v-card-text class="bg-white text--primary">
                            <b>
                                {{ item.note }}
                            </b>
                        </v-card-text>
                        <v-divider v-if="item.created_at == new Date('d.m.Y')"></v-divider>
                    </v-card>
                </v-list-item>
            </transition-group>
            </v-list>
            <v-list
            style="height: 100%;"
            v-else
            class="d-flex justify-content-center align-items-center"
            >
                <DefaultPreloader 
                :size="96"
                :width="7"
                />
            </v-list>
        </v-card-text>
        <v-divider class="m-0"></v-divider>
		<v-card-actions 
        class="px-4"
        >
        <v-row 
        class="d-flex justify-content-between align-items-center p-0 m-0"
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
                    class="custom-alert"
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
                >
                    Close
                </v-btn>        
            </v-col>
        </v-row>

		</v-card-actions>
	</v-card>
</template>

<script>
import DefaultPreloader from '../../UI/DefaultPreloader.vue';
import DeleteButton from '../../UI/DeleteButton.vue';
import AddSubtaskButton from '../../UI/AddSubtaskButton.vue';
    export default {
        props: {
            notesList: {
                type: Array,
                required: true,
            },
            isLoading: {
                type: Boolean,
            },
            item: {
                type: Object,
                required: true,
            },
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
                    }
                ]
            };
        },

        components: {
            DefaultPreloader,
            DeleteButton,
            AddSubtaskButton,
        },

        methods: {
            deleteNote(noteId) {
                axios.post('/delete-note', {note_id: noteId})
                .then(response => {
                    const {data} = response;
                    if (data.status === 'success') {
                        const newNotesList = [...this.notesList].filter(note => note.id !== noteId);
                        const todayAmount  = newNotesList.length;

                        this.$emit('updateNotesInfo', {notesList: newNotesList, todayAmount});
                        this.setAlertData(data);
                        this.isShowAlert = true;
                        
                        clearTimeout(this.closeAlertTime); //вот тут не уверен

                        this.closeAlertTime = setTimeout(() => {
                            this.removeAlert();
                        }, this.showAlerTime)
                    }
                })
            },

            setAlertData({status, message}) {
                this.alertData = {
                    type: status,
                    text: message,
                };
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

            addNewNote() {
                const task_id = this.item.taskId;
                const note    = this.newNoteInpuVal.trim();
                axios.post('/add-note', {task_id, note})
                .then(response => {
                    const {data} = response;

                    if (data.status === 'success') {
                        console.log(data);
                    }
                })
            }
        }
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
</style>