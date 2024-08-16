import { uuid } from "vue-uuid";

//Разделить логику мутаторов Сортировочного критерия!!!
export default {
    state: {details: {}},
    mutations: {
        initializeDetailsStore(state, {key, details, completedPercent, detailsSortBy}) {
            state.details = {...state.details, [key]: {details, completedPercent, detailsSortBy}};
        },
        updateDetailsSortingCritInCurrentTask(state, {key, newDetailsSortingCrit}) {
            state.details[key].detailsSortBy = newDetailsSortingCrit;
        },

        sortDetails(state, {key}) {
            const currentTaskData    = state.details[key];
            const currentTaskDetails = currentTaskData.details;
            const formatDate = (date) => Date.parse(date.created_at_date);

			const sortByCreatedAt = (detailA, detailB, direction = 'asc') => {
					const detailADate = formatDate(detailA);
					const detailBDate = formatDate(detailB);
					switch (direction) {
						case 'asc':
							return detailADate - detailBDate 
						case 'desc':
							return detailBDate - detailADate;
						default:
							return detailADate - detailBDate 
					}
			}
                
			switch (currentTaskData.detailsSortBy) {
				case 'created-at-asc':
					currentTaskDetails.sort((detailA, detailB) => {
						return sortByCreatedAt(detailA, detailB, 'asc');
					});
				break;
				case 'created-at-desc':
					currentTaskDetails.sort((detailA, detailB) => {
						return sortByCreatedAt(detailA, detailB, 'desc');
					});
				break;
				case 'is_ready-asc':
					currentTaskDetails.sort((detailA, detailB) => {

						if (detailA.is_ready || detailB.is_ready) {
							if (detailA.is_ready && !detailB.is_ready) return -1;
							if (!detailA.is_ready && detailB.is_ready) return 1;

							return sortByCreatedAt(detailA, detailB, 'asc');
						} else {
							return sortByCreatedAt(detailA, detailB, 'asc');
						}
					});
				break;
				case 'unready-asc':
					currentTaskDetails.sort((detailA, detailB) => {

					if (!detailA.is_ready || !detailB.is_ready) {
						if (!detailA.is_ready && detailB.is_ready) return -1;
						if (detailA.is_ready && !detailB.is_ready) return 1;

						return sortByCreatedAt(detailA, detailB, 'asc');
					} else {
						return sortByCreatedAt(detailA, detailB, 'asc');
					}
				});
				break;
				default:
					currentTaskDetails.sort((detailA, detailB) => {
						return sortByCreatedAt(detailA, detailB, 'asc');
					});
				break;
			}
        }
    },
    getters: {
        getDetailsData(state) {
            return (id) => {
                return state.details[id];
            }
        },

        getDetailsSortBy(state) {
            return(id) => {
                const detailsSortingCrit = state.details[id].detailsSortBy;
                if (detailsSortingCrit === undefined) {
                    return 'created-at-asc'; //по возможности убрать хардкод
                }
                return 'created-at-asc';
            }
        }
    },
    actions: {
        async updateDetailsSortingCrit({commit, getters}, payload) {
            const detailsData = getters.getDetailsData(payload.key);
            if (detailsData) {
                commit('updateDetailsSortingCritInCurrentTask', payload);
                if (detailsData.details.length >= 2) {
                    commit('sortDetails', payload);
                }
            }

        },
        async fetchDetails(context, payload) {
            try {
                const {requestData} = payload;

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
                        uniqKey: uuid.v1(),
                        created_at_date: element.created_at_user_time.slice(//получаю дату без времени
                            0, element.created_at_user_time.trim().indexOf(' ')
                        ),
                    }) 
                });
                const transformedCompletedPercent = await context.dispatch('checkCompletedPercent', {complPercentResp: detailsData.completedPercent});
                context.commit('initializeDetailsStore', {
                    key:              requestData.task_id,
                    details:          transformedDetails,
                    completedPercent: transformedCompletedPercent,
                    detailsSortBy:    'created-at-asc',
                });
            } catch(error) {
                console.error(error);
            }
        },

        async addNewDetail(context, {newDetail}) {
            try {
                console.log(newDetail);
                const response = await axios.post('/add-sub-task',{task_id : newDetail.taskId, hash: newDetail.hash, sub_plan: newDetail})
                const respData = response.data;
                
                if (response.status === 200) {
                    
                } 
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