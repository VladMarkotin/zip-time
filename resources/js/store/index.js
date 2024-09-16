import Vue from 'vue'
import Vuex from 'vuex'
import Challenge from './modules/challenge'
import Details from './modules/details';
import Notes from './modules/notes';
import PersonalResults from './modules/personalResults';
import WindowScreenWidth from './modules/windowScreenWidth';
import TaskData from './modules/taskData';

Vue.use(Vuex)

export default new Vuex.Store({
     modules: {
        Challenge,
        Details,
        Notes,
        PersonalResults,
        WindowScreenWidth,
        TaskData,
     }
})