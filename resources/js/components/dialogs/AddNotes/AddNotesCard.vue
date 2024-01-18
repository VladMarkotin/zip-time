<template>
    <v-card
	width="400"
    >
		<v-card-title>Notes list</v-card-title>
		<v-divider></v-divider>
        <v-card-text 
        style="height: 470px; position: relative; overflow:hidden;"
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
        </v-card-text>
        <v-divider></v-divider>
		<v-card-actions>
			    <v-btn
					color="blue-darken-1"
					variant="text"
				>
					Close
				</v-btn>
				<v-btn
					color="blue-darken-1"
					variant="text"
				>
					Save
				</v-btn>
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
                        
                        setTimeout(() => {
                            this.removeAlert();
                        }, 1500)
                    }
                })
            },

            setAlertData({status, message}) {
                console.log(status);
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
        position: absolute;
        width: 400px;
        margin: 0;
        bottom: 0;
        left: 0;
    }

    .custom-alert_appearance {
        animation: .3s custom_alert_show ease;
    }

    .custom-alert_leave {
        animation: .3s custom_alert_leave ease;
    }

    @keyframes custom_alert_show {
		from { opacity: 0; bottom: 10px;}
		to { opacity: 1; bottom: 0;}
	}

	@keyframes custom_alert_leave {
		from { opacity: 1; bottom: 0;}
		to { opacity: 0; bottom: -10px;}
	}
</style>