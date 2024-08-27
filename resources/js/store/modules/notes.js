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
        }
    },
    getters: {
        getNotesData(state) {
            return (key) => {
                return state.notes[key];
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

        async addNote({getters, commit}, {task_id, note}) {
            try {
                const response = await axios.post('/add-note', {task_id, note});
                const respData = response.data;

                if (respData.status === 'success') {
                    const currentTaskData = getters.getNotesData(task_id);

                    if (currentTaskData) {
                        commit('ADD_NOTE', {key: task_id, newNote: respData.new_note});
                    }
                }

                return response;
            } catch(error) {
                console.error(error);
            }
        },
    },
}