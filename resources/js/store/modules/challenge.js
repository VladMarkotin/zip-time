

export default {
    actions:{
        async fetchChallenges(ctx) {
            try {
                const result = await axios.post(
                    'get-challenges',
                );
                ctx.commit('updateChallenges', result)
            } catch(error) {
                console.error(error);
            }
        }
    },
    
    mutations:{
        updateChallenges(state, ch) {
            const {challenges} = ch.data.challenges;
            state.challenges = challenges;   
        }
    },

    state: {
        challenges: []
    },

    getters: {
         allChallenges(state) {
            return  state.challenges;
        },

        getChallengeDataById(state){
            return (id, field) => {
                const currentChallenge = state.challenges.find(challenge => challenge.id === id);
                if (currentChallenge) {
                    const challengeData = JSON.parse(currentChallenge.terms);

                    switch(field) {
                        case 'description':
                            return challengeData.description;
                        case 'goalText':
                            return challengeData.rules.goalText;
                    }
                }

                return '';
            }
        },
    },
}