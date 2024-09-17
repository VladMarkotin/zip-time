export default {
    state: {
        dayStatus: 2,
        taskData: [],
    },
    mutations: {
        INITIALIZE_TASK_DATA_STORE(state, {taskData, dayStatus}) {
            state.dayStatus = dayStatus;
            state.taskData = [...taskData];
        },
        UPDATE_TASK_DATA(state, {updatedTaskData}) {
            // ожидает {updatedTaskData: {
            //     taskId: taskId,
            //     Changeable property of object: new value,
            //     Changeable property of object: new value,
            // }}
            state.taskData = state.taskData.map(taskData => {
                if (taskData.taskId !== updatedTaskData.taskId) return taskData
                return {
                    ...taskData,
                    ...updatedTaskData
                }
            });
        }
    },
    getters: {
        getFullTaskData(state) {
            return (taskId) => {
                return  state.taskData.find(taskdata => taskdata.taskId === taskId);
            }
        },
        getTaskData(state) {
            return (taskId, key) => {
                const currenTaskData = state.taskData.find(taskdata => taskdata.taskId === taskId);
                return currenTaskData[key];
            }
        },
        getDayStatus(state) {
            return state.dayStatus;
        }
    },
    actions: {
        async editCardData({getters, commit, dispatch}, {editedCardData}) {
            try {
                const currenTaskData = getters.getFullTaskData(editedCardData.taskId);
                const storeData = {};
                //Сраниваю данные в сторе с переданными, что бы понять поменялось ли что-то и надо ли редактировать в базе
                Object.keys(editedCardData).forEach(key => {
                    storeData[key] = currenTaskData[key];
                })
                
                if (JSON.stringify(editedCardData) !== JSON.stringify(storeData)) {
                    const response = await axios.post('/edit-card',{
						task_id : editedCardData.taskId, 
						time :    editedCardData.time, 
						priority: editedCardData.priority,
                        type:     editedCardData.type,
                    }) 

                    const {updated_data} = response.data;
                    if (response.status === 200 && updated_data) {
                        updated_data.taskId = editedCardData.taskId; //добавляю taskId для мутации
                        if (Object.keys(updated_data).includes('type')) {
                            updated_data.mark = '';
                        };
                        
                        commit('UPDATE_TASK_DATA', {updatedTaskData: updated_data});			
                    }
                    return response;
                }

            } catch(error) {
                console.error(error);
            }
        }
    },
}