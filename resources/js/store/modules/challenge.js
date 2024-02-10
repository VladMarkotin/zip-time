

export default {
    actions:{},

    mutations:{},

    state: {
        challenges: [1,2,3]
    },

    getters: {
        allChallenges(state) {
            return state.challenges
        }
    },
}