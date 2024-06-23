import { watch } from "vue";

export default function createWatcherForDefSavTaskMixin(watchPath) {
    return {
      watch: {
        [watchPath]: {
        //Каждый раз когда пользователь меняет выбранный хешкод на фронте вызывается функция, 
        //которая проверяет не выбрана ли Дефолтная таска и если выбрана она, то подготавлияет параметра для запроса на бэкэнд (id дефолтной задачи)
          handler(selectedHashCode) {
                const defaultSavedTaskData = this.defaultSavedTaskData;

                defaultSavedTaskData.isDefaultSAvedTaskSelected = this.isDefaultSavedTaskSelected;


                const getSelectedSavedTaskId = ({isDefaultSAvedTaskSelected, defaultSavedTasks}) => {
                    if (!isDefaultSAvedTaskSelected) return null;
                
                    const selectedSavedTasData = defaultSavedTasks.find(({hash_code}) => selectedHashCode === hash_code)
                
                    return selectedSavedTasData.id ?? null;
                }

                defaultSavedTaskData.selectedSavedTaskId = getSelectedSavedTaskId(defaultSavedTaskData);
          },
        }
      }
    };
  }