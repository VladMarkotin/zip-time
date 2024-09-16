export default {
    state: {
        taskData: [],
    },
    mutations: {
        INITIALIZE_TASK_DATA_STORE(state, {taskData}) {
            state.taskData = [...taskData];
        },
        UPDATE_TASK_DATA(state, {updatedTaskData}) {
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
        getTaskData(state) {
            return (taskId, key) => {
                const currenTaskData = state.taskData.find(taskdata => taskdata.taskId === taskId);
                return currenTaskData[key];
            }
        }
    },
    actions: {

    },
}