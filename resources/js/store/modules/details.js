import { uuid } from "vue-uuid";

export default {
    state: {
        details: {},
    },
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
        },

        updateCompletedPercentInCurrentTask(state, {key, completedPercent}) {
            state.details[key].completedPercent = completedPercent;
        },

        addNewDetailInCurrentTask(state, {key, newDetail}) {
            state.details[key].details.push(newDetail); 
        },

        deleteDetailInCurrentTask(state, {key, id}) {
            const { details } = state.details[key];

            state.details[key] = {
            ...state.details[key],
            details: details.filter(detail => detail.taskId !== id)
            };
        },

        editDetailInCurrentTask(state, {key, id, title, text}) {
            const { details } = state.details[key];

            state.details[key] = {
            ...state.details[key],
            details: details.map(detail => {
                if (detail.taskId === id) {
                    return {
                        ...detail,
                        title,
                        text,
                    }
                }
                return detail;
            })
            };
        }
    },
    getters: {
        getDetailsData(state) {
            return (key) => {
                return state.details[key];
            }
        },

        getDetail(state) {
            return (key, id) => {
                return state.details[key].details.find(detail => detail.taskId === id);
            }
        },

        getDetailsSortBy(state) {
            return(key) => {
                const detailsSortingCrit = state.details[key].detailsSortBy;
                if (detailsSortingCrit === undefined) {
                    return 'created-at-asc'; //по возможности убрать хардкод
                }
                return 'created-at-asc';
            }
        },

        getCompletedPercent(state) {
            return (key) => {
                const detailsData = state.details[key];

                if (detailsData === undefined) {
                    return 0;
                }

                return detailsData.completedPercent;
            }
        },

        getDetailsRules(state) {
            return state.detailsChecks.detailsRules;
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

        async addNewDetail({getters, commit, dispatch}, {newDetail}) {
            try {
                const response = await axios.post('/add-sub-task',{task_id : newDetail.taskId, hash: newDetail.hash, sub_plan: newDetail})
                const respData = response.data;

                if (respData.status === 'success') {
                    const key = newDetail.task_id
                    newDetail.taskId = respData.subtaskId
                    delete newDetail.task_id;

                    const currentTaskData = getters.getDetailsData(key);

                    if (currentTaskData) {
                        const transformedCompletedPercent = await dispatch('checkCompletedPercent', {complPercentResp: respData.completedPercent})

                        commit('addNewDetailInCurrentTask', {key, newDetail});
                        commit('updateCompletedPercentInCurrentTask', {key, completedPercent: transformedCompletedPercent});
                        commit('sortDetails', {key});
                    }
                } 

                return response;
            } catch(error) {
                console.error(error);
            }
        },

        async deleteDetail({getters, commit, dispatch}, {taskId, detailId}) {
            try {
                const response = await axios.post('/del-sub-task',{task_id : detailId});
                const respData = response.data;

                if (respData.status === 'success') {
                    const currentTaskData = getters.getDetailsData(taskId);

                    if (currentTaskData) {
                        const currentDetail = getters.getDetail(taskId, detailId);

                        if (currentDetail) {
                            const transformedCompletedPercent = await dispatch('checkCompletedPercent', {complPercentResp: respData.completedPercent})

                            commit('deleteDetailInCurrentTask', {key: taskId, id: detailId});
                            commit('updateCompletedPercentInCurrentTask', {key: taskId, completedPercent: transformedCompletedPercent});
                            commit('sortDetails', {key: taskId});
                        }
                    }
                }
                
                return response;
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

        async updateCompletedStatus({commit, getters, dispatch}, payload) {
            try {
                const response = await axios.post('/complete-sub-task', payload);
                const data = response.data;
                
                if (data.status = 'success') {
                    const transformedCompletedPercent = await dispatch('checkCompletedPercent', {complPercentResp: data.completedPercent})
                    
                    const detailsData = getters.getDetailsData(payload.task_id);

                    if (detailsData) {
                        commit('updateCompletedPercentInCurrentTask', {
                            key:              payload.task_id, 
                            completedPercent: transformedCompletedPercent
                        });
                    }

                }

                return response;
            } catch(error) {
                console.error(error);
            }
        },

        async editDetail({commit, getters}, {taskId, detailId, title, text}) {
            try {
                const response = await axios.post('/edit-subtask', {id: detailId, title, text,})
                const respData = response.data;

                if (respData.status === 'success') {
                    const currentDetail = getters.getDetail(taskId, detailId);

                    if (currentDetail) {
                        commit('editDetailInCurrentTask', {
                            key: taskId, 
                            id:  detailId,
                            title,
                            text,       
                        });
                    }
                }

                return response;
            } catch(error) {
                console.error(error);
            }
        },
    }
}