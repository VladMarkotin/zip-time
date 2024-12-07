import { uuid } from "vue-uuid";

const transformDetails = (details) => {
    return details.map(element => {
        const originalDate = element.created_at;
        const date = new Date(originalDate);

        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        const seconds = String(date.getSeconds()).padStart(2, '0');

        const formattedDate = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
        return ({
            title: element.title,
            text:  element.text,
            taskId: element.id,
            is_ready: element.is_ready, 
            checkpoint: element.checkpoint,
            is_old_compleated: element.is_old_compleated,
            done_at_user_time: element.done_at_user_time,
            is_ready: element.is_ready,
            uniqKey: uuid.v1(),
            created_at_date: formattedDate,
        })
    });
};

const checkCompletedPercent =({complPercentResp}) => {
    return (typeof complPercentResp === 'number') && !(Number.isNaN(+complPercentResp))
            ? complPercentResp
            : editCompletedPercent({compPercent: complPercentResp});
};

const editCompletedPercent = ({compPercent}) => {
    if (typeof compPercent === 'string') {
        return +(compPercent.replace(/[^0-9.]/g,""));
    }
    return compPercent;
};

const DEFAULT_DETAILS_SORT_BY = 'created-at-asc';
const DEFAULT_DETAILS_MODE    = 'actual';

export default {
    state: {
        details: {},
    },
    mutations: {
        INITIALIZE_DETAILS_STORE(state, {detailsData}) {
            const detailsTransformedData = detailsData.map(data => ({
                key: data.key,
                completedPercent: checkCompletedPercent({complPercentResp: data.detailsCompletedPercent}),
                details:  transformDetails(data.detailsData),
                detailsSortBy:    DEFAULT_DETAILS_SORT_BY,
                mode: DEFAULT_DETAILS_MODE,
            }));
            detailsTransformedData.forEach(({key, details, completedPercent, detailsSortBy, mode}) => {
                state.details = {...state.details, [key]: {details, completedPercent, detailsSortBy, mode}};
            })
        },
        
        UPDATE_DETAILS_SORTING_CRIT(state, {key, newDetailsSortingCrit}) {
            state.details[key].detailsSortBy = newDetailsSortingCrit;
        },

        SORT_DETAILS(state, {key}) {
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

        UPDATE_COMPLETED_PERCENT(state, {key, completedPercent}) {
            state.details[key].completedPercent = completedPercent;
        },
        
        ADD_NEW_DETAIL(state, {key, newDetail}) {
            state.details[key].details.push(newDetail); 
        },
        
        DELETE_DETAIL(state, {key, id}) {
            const { details } = state.details[key];

            state.details[key] = {
            ...state.details[key],
            details: details.filter(detail => detail.taskId !== id)
            };
        },
        
        EDITE_DETAIL(state, {key, id, title, text}) {
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
        },

        SET_MODE(state, {key, newMode}) {
            state.details[key] = {...state.details[key], mode: newMode};
        },

        RESET_FILTERS_TO_DEF_VAL(state, {key}) {
            state.details[key] = {...state.details[key], detailsSortBy: DEFAULT_DETAILS_SORT_BY, mode: DEFAULT_DETAILS_MODE}
        }
    },
    getters: {
        getAllDetails(state) {
            return state.details;
        },

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
                    return DEFAULT_DETAILS_SORT_BY;
                }
                return detailsSortingCrit;
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

        getMode(state) {
            return (key) => {
                const detailsData = state.details[key];

                if (detailsData === undefined) {
                    return DEFAULT_DETAILS_MODE;
                }

                return detailsData.mode;
            }
        },

        getUnreadyReqDetails(state) {
            return (key) => {
                const {details} = state.details[key];
                return details.filter(detail => !detail.is_ready && detail.checkpoint);                
            }
        }
    },
    actions: {
        async updateDetailsSortingCrit({commit, getters}, payload) {
            const detailsData = getters.getDetailsData(payload.key);
            if (detailsData) {
                commit('UPDATE_DETAILS_SORTING_CRIT', payload);
                if (detailsData.details.length >= 2) {
                    commit('SORT_DETAILS', payload);
                }
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
                        const transformedCompletedPercent = checkCompletedPercent({complPercentResp: respData.completedPercent});

                        commit('ADD_NEW_DETAIL', {key, newDetail});
                        commit('UPDATE_COMPLETED_PERCENT', {key, completedPercent: transformedCompletedPercent});
                        commit('SORT_DETAILS', {key});
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
                            const transformedCompletedPercent = checkCompletedPercent({complPercentResp: respData.completedPercent})

                            commit('DELETE_DETAIL', {key: taskId, id: detailId});
                            commit('UPDATE_COMPLETED_PERCENT', {key: taskId, completedPercent: transformedCompletedPercent});
                            commit('SORT_DETAILS', {key: taskId});
                        }
                    }
                }
                
                return response;
            } catch(error) {
                console.error(error);
            }
        },

        async updateCompletedStatus({commit, getters, dispatch}, payload) {
            try {
                const response = await axios.post('/complete-sub-task', payload);
                const data = response.data;
                
                if (data.status = 'success') {
                    const transformedCompletedPercent = checkCompletedPercent({complPercentResp: data.completedPercent});
                    
                    const detailsData = getters.getDetailsData(payload.task_id);

                    if (detailsData) {
                        commit('UPDATE_COMPLETED_PERCENT', {
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
                        commit('EDITE_DETAIL', {
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

        reset_to_default_values({commit, getters}, {taskId}) {
            const payload = {key: taskId};
            const currentTaskData = getters.getDetailsData(taskId);
            commit('RESET_FILTERS_TO_DEF_VAL', payload);

            if (currentTaskData) {
                commit('SORT_DETAILS', payload);
            }
        }
    }
}