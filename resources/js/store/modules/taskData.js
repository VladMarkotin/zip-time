export default {
    state: {
        taskData: [],
    },
    mutations: {
        INITIALIZE_TASK_DATA_STORE(state, {taskData}) {
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
						priority: editedCardData.priority
                    }) 
                    if (response.data.status == 'success') {
                        commit('UPDATE_TASK_DATA', {updatedTaskData: editedCardData});			
                    }
                    return response;
                }

            } catch(error) {
                console.error(error);
            }
        }
    },
}