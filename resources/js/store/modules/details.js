export default {
    state: {details: {}},
    mutations: {
        initializeDetailsStore(state, {key, details, completedPercent}) {
            state.details = {...state.details, [key]: {details, completedPercent}};
        },
    },
    actions: {
        async fetchDetails(context, payload) {
            try {
                const {requestData, uniqKey} = payload;

                const response = await axios.post('/get-sub-tasks', requestData);
                const detailsData = response.data;

                const details = detailsData.data;
                const transformedDetails = [];

                details.forEach(element => {
                    transformedDetails.push({
                        title: element.title,
                        text:  element.text,
                        taskId: element.id,
                        is_ready: element.is_ready, 
                        checkpoint: element.checkpoint,
                        is_old_compleated: element.is_old_compleated,
                        done_at_user_time: element.done_at_user_time,
                        is_ready: element.is_ready,
                        uniqKey,
                        created_at_date: element.created_at_user_time.slice(//получаю дату без времени
                            0, element.created_at_user_time.trim().indexOf(' ')
                        ),
                    }) 
                });
                const transformedCompletedPercent = await context.dispatch('checkCompletedPercent', {complPercentResp: detailsData.completedPercent});
                context.commit('initializeDetailsStore', {
                    key:              requestData.task_id,
                    details:          transformedDetails,
                    completedPercent: transformedCompletedPercent
                });
            } catch(error) {
                console.error(error);
            }
        },

        checkCompletedPercent(context, {complPercentResp}) {
            return (typeof complPercentResp === 'number') && !(Number.isNaN(+complPercentResp))
                    ? complPercentResp
                    : context.dispatch('editCompletedPercent', {compPercent: complPercentResp});
        },

        editCompletedPercent(_, {compPercent}) {
            if (typeof compPercent === 'string') {
                return +(compPercent.replace(/[^0-9.]/g,""));
            }
            return compPercent;
        },
    }
}