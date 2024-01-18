<template>
    <v-card
	width="400"
    >
		<v-card-title>Notes list</v-card-title>
		<v-divider></v-divider>
        <v-card-text style="min-height: 468px;">
            <v-list 
            v-if="!isLoading"
            style="min-height: inherit;"
            >
            <transition-group name="list" tag="div" class="notes-wrapper">
                <v-list-item v-for="(item, i) in notesList" :key="item.id" class="list-item">
                    <v-card
                    width="800"
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
            style="min-height: inherit;"
            v-else
            class="d-flex justify-content-center align-items-center"
            >
                <DefaultPreloader 
                :size="96"
                :width="7"
                />
            </v-list>
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
        
    }
    .list-enter-active, .list-leave-active {
    transition: all .3s;
    }
    .list-enter, 
    .list-leave-to  {
    opacity: 0;
    transform: translateX(30px);
    }
</style>