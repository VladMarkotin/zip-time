

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
            //console.log(ch.data)
            //ch.data.forEach((element) => console.log(element));
            state.challenges.push(ch.data.completness)
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