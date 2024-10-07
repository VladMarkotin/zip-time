export default {
    state: {
        disabledDates: [],
        emergencyModeDates: [],
    },
    mutations: {
        SET_EMERGENCY_MODE_DATES(state, {emergencyModeDates}) {
            state.emergencyModeDates = [...emergencyModeDates];
        },
        SET_DISABLED_DATES(state, {disabledDates}) {
            state.disabledDates = disabledDates;
        }
    },
    getters: {
        getDisabledDates(state) {
            return state.disabledDates;
        }
    },
    actions: {
        async fetchEmergencyModeDates(_, payload) {
            try {
                const response = await axios.post('/getEmergencyModeDates', payload);
                if (response.status === 200) {
                    return response.data.emergency_mode_dates;
                }
                return [];
             } catch(error) {
                console.error(error);
             }
        },
        //переименовать в setDisabledDates
        async setDisabledDates({commit, dispatch}, {todayDate, selectedPlanDate})  {
            try {
                const emergencyModeDates = await dispatch('fetchEmergencyModeDates', {todayDate});
                commit('SET_EMERGENCY_MODE_DATES', {emergencyModeDates});

                if(selectedPlanDate && !emergencyModeDates.includes(selectedPlanDate)) {
                    commit('SET_DISABLED_DATES', {disabledDates: [todayDate, ...emergencyModeDates]});
                } else {
                    commit('SET_DISABLED_DATES', {disabledDates: emergencyModeDates});
                }
            } catch(error) {
                console.error(error);
            }
        }
    }
}