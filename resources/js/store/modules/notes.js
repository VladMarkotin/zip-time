export default {
    state: {
        notes: {},
    },
    mutations: {
        INITIALIZE_NOTES_STORE(state, {key, notes}) {
            state.notes = {...state.notes, [key]: notes};
        },

        ADD_NOTE(state, {key, newNote}) {
            state.notes[key].unshift(newNote);
        },

        REMOVE_NOTE(state, {key, id}) {
            state.notes = {
                ...state.notes,
                [key]: state.notes[key].filter(note => note.id !== id),
            };
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
        async fetchNotes(context, {requestData}) {
            try {
                const response = await axios.post('/get-saved-notes', requestData);

                if (response.status === 200) {
                    context.commit('INITIALIZE_NOTES_STORE', {
                        key:   requestData.task_id,
                        notes: response.data,
                    });    
                }
            } catch(error) {
                console.error(error);
            }
        },

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
        }
    },
}