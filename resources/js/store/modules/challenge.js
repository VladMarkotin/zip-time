

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
            const obj = ch.data.challenges
            state.challenges.push(obj)
            //console.log(state.challenges)
        }
    },

    state: {
        challenges: []
    },

    getters: {
         allChallenges(state) {
            return  (state.challenges[0] )
        }
    },
}