<template>
    <v-card
	width="450"
    >
		<v-card-title>Notes list</v-card-title>
		<v-divider></v-divider>
        <v-row class="m-0">
            <v-col class="px-6 pt-0 pb-0">
                <v-text-field
                label="New note"
                >
                </v-text-field>
            </v-col>
        </v-row>
		<v-divider></v-divider>
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
    export default {
        props: {
            notesList: {
                type: Array,
                required: true,
            },
            isLoading: {
                type: Boolean,
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
                }
            };
        },

        components: {
            DefaultPreloader,
            DeleteButton,
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