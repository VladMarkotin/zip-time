export default {
    state: {
        taskData: [],
    },
    mutations: {
        INITIALIZE_TASK_DATA_STORE(state, {taskData}) {
            state.taskData = [...taskData];
        },
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