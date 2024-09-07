import Vue from 'vue'
import Vuex from 'vuex'
import Challenge from './modules/challenge'
import Details from './modules/details';
import Notes from './modules/notes';

Vue.use(Vuex)

export default new Vuex.Store({
     modules: {
         Challenge,
         Details,
         Notes,
     }
})