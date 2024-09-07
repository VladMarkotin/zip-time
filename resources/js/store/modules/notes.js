export default {
    state: {
        notes: {},
    },
    mutations: {
        INITIALIZE_NOTES_STORE(state, {notesData}) {
            notesData.forEach(({key, notesData}) => {
                state.notes = {...state.notes, [key]: notesData};
            })
        },

        ADD_NOTE(state, {key, newNote}) {
            state.notes[key].unshift(newNote);
        },

        REMOVE_NOTE(state, {key, id}) {
            state.notes = {
                ...state.notes,
                [key]: state.notes[key].filter(note => note.id !== id),
            };
        },

        EDIT_NOTE(state, {key, id, editedNote}) {
            state.notes = {
                ...state.notes,
                [key]: state.notes[key].map(note => {
                    if (note.id === id) return editedNote;
                    return note
                }),
            }
        }
    },
    getters: {
        getNotesData(state) {
            return (key) => {
                return state.notes[key];
            }
        },

        getNote(state) {
            return (key, id) => {
                return state.notes[key].find(note => note.id === id)
            }
        },
    },
    actions: {
        async addNote({getters, commit}, {taskId, note}) {
            try {
                const response = await axios.post('/add-note', {task_id: taskId, note});
                const respData = response.data;

                if (respData.status === 'success') {
                    const currentTaskData = getters.getNotesData(taskId);

                    if (currentTaskData) {
                        commit('ADD_NOTE', {key: taskId, newNote: respData.new_note});
                    }
                }

                return response;
            } catch(error) {
                console.error(error);
            }
        },

        async removeNote({getters, commit}, {taskId, noteId}) {
            const response = await axios.post('/delete-note', {note_id: noteId});
            const respData = response.data;
            
            if (respData.status === 'success') {
                const currentTaskData = getters.getNotesData(taskId);

                if (currentTaskData) {
                    const currentNote = getters.getNote(taskId, noteId);
                    
                    if (currentNote) {
                        commit('REMOVE_NOTE', {key: taskId, id: noteId});
                    }
                }
            }

            return response;
        },

        async editCurrentNote({getters, commit}, {taskId, updatedNote}) {
            const noteId = updatedNote.id;
            const note   = updatedNote.note;

            try {
                const response = await axios.post('/update-note', {
                    task_id: taskId,
                    note_id: noteId, 
                    note, 
                })
                const respData = response.data;
                
                if (respData.status === 'success') {
                    const currentNote = getters.getNote(taskId, noteId);
                    
                    if (currentNote) {
                        commit('EDIT_NOTE', {
                            key:        taskId, 
                            id:         noteId, 
                            editedNote: respData.edited_note,    
                        });
                    }
                }

                return response;
            } catch(error) {
                console.error(error);
            }
        },
    },
}