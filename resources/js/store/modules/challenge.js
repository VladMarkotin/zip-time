

export default {
    actions:{
        async fetchChallenges(ctx) {
            const result = await axios.post(
                'get-challenges',
            );
            ctx.commit('updateChallenges', result)
        }
    },
    
    mutations:{
        updateChallenges(state, ch) {
            let obj = JSON.parse(JSON.stringify(ch.data))
            state.challenges.push(obj)
        }
    },

    state: {
        challenges: []
    },

    getters: {
        allChallenges(state) {
            return state.challenges
        }
    },
}