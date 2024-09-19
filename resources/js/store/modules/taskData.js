const getTransformedType = (type) => {
    switch (type) {
        case 0:
            return 'reminder';
        case 1:
            return 'task';
        case 2:
            return 'required task';
        case 3:
            return 'non required job'
        case 4:
            return 'required job';
    }
};

const transformTaskData = (taskData) => {
    const transformedTaskData = taskData.map(taskData => ({
        hash:     taskData.hash,
        mark:     taskData.mark,
        priority: taskData.priority,
        taskId:   taskData.taskId,
        taskName: taskData.taskName,
        time:     taskData.time,
        type:     taskData.type,
        transformedType: getTransformedType(taskData.type)}));

    return transformedTaskData;
}

export default {
    state: {
        dayStatus: 2,
        taskData: [],
    },
    mutations: {
        INITIALIZE_TASK_DATA_STORE(state, {taskData, dayStatus}) {
            const transfomedTaskData = transformTaskData(taskData);

            state.dayStatus = dayStatus;
            state.taskData = [...transfomedTaskData];

            console.log(state.taskData);
        },
        UPDATE_TASK_DATA(state, {updatedTaskData}) {
            // ожидает {updatedTaskData: {
            //     taskId: taskId,
            //     Changeable property of object: new value,
            //     Changeable property of object: new value,
            // }}

            if (Object.keys(updatedTaskData).includes('type')) {
                updatedTaskData = {...updatedTaskData, transformedType: getTransformedType(updatedTaskData.type)};
            }

            state.taskData = state.taskData.map(taskData => {
                if (taskData.taskId !== updatedTaskData.taskId) return taskData
                return {
                    ...taskData,
                    ...updatedTaskData
                }
            });
            console.log(state.taskData);
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
        },
        getRequiredTasks(state) {
            return state.taskData.filter(task => [4, 2].includes(task.type));
        },
        getNonRequiredTasks(state) {
            return state.taskData.filter(task => [3, 1].includes(task.type));
        },
        checkIsCurrentTaskReady(_, getters) {
            return ({taskId, defaultConfigs}) => {
                const type = getters.getTaskData(taskId, 'type');
                const mark = getters.getTaskData(taskId, 'mark');

                const classForCard = {
                    ready:   'card-wrapper_ready',
                    unready: 'card-wrapper_unready',
                }

				const checkTask = (data) => {
					const {type, mark} = data;

					if (defaultConfigs) {
						const maxMark = +defaultConfigs[0].maxMark;
						const minMark = +defaultConfigs[0].minMark;
						switch (type) {
							case 'task':
								return mark === 99 //хардкод
									? classForCard.ready
									: classForCard.unready;
							case 'job':
								return mark >= minMark && mark <= maxMark
									? classForCard.ready
									: classForCard.unready;
							default:
								return classForCard.unready;
						}
					}

                    return classForCard.unready;
				}
				
				switch(type) {
					case 1:
					case 2:
						return checkTask({type: 'task', mark});
					case 3:
					case 4:
						return checkTask({type: 'job', mark});
					default:
						return classForCard.unready;
				}
            }
        }
    },
    actions: {
        async editCardData({getters, commit}, {editedCardData}) {
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