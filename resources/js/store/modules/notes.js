export default {
    state: {
        notes: {},
    },
    mutations: {
        INITIALIZE_NOTES_STORE(state, {key, notes}) {
            state.notes = {...state.notes, [key]: notes};
        },
    },
    getters: {
        getNotesData(state) {
            return (key) => {
                return state.notes[key];
            }
        },
    },
    actions: {
        async fetchNotes(context, payload) {
            try {
                const response = await axios.post('/get-saved-notes', payload);

                if (response.status === 200) {
                    context.commit('INITIALIZE_NOTES_STORE', {
                        key:   payload.task_id,
                        notes: response.data,
                    });    
                }
            } catch(error) {
                console.error(error);
            }
        },
    },
}