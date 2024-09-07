export default {
    state: {
        personalResults: {
            is_emergency_mode_activated: false,
            better_then: 0,
            more_pesponsible: 0,
            user_purposelness: 0,
            better_then_purposelness: 0,
            is_only_one_user_in_group: false,
            ratingData: {},
        },
    },
    mutations: {
        INITIALIZE_PERSONAL_RESULTS_STORE(state, {personalResults}) {
            state.personalResults = {...personalResults}
        }
    },
    getters: {
        getPersonalResultData(state) {
            return (key) => {
                return state.personalResults[key];
            }
        }
    },
    actions: {
        async fetchPersonalResults({commit}) {
            try {
                const response = await axios.post('/get-results');
                const getData = (response) => (key) => response.data[key];
                const getValue = getData(response);

                const is_emergency_mode_activated = getValue('is_emergency_mode_activated');
                const better_then                 = getValue('better');
                const more_pesponsible            = getValue('more_pesponsible');
                const user_purposelness           = getValue('user_purposelness');
                const better_then_purposelness    = getValue('better_then_purposelness');
                const is_only_one_user_in_group   = getValue('is_only_one_user_in_group');
                const ratingData                  = getValue('ratingData');

                commit('INITIALIZE_PERSONAL_RESULTS_STORE', {
                    personalResults: {
                        is_emergency_mode_activated,
                        better_then,
                        more_pesponsible,
                        user_purposelness,
                        better_then_purposelness,
                        is_only_one_user_in_group,
                        ratingData,
                    }
                })
            } catch (error) {
                
            }
        }
    },
}   