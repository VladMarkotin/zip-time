import Vue from 'vue'
import Vuex from 'vuex'
import Challenge from './modules/challenge'

Vue.use(Vuex)

export default new Vuex.Store({
     modules: {
        Challenge,
     }
})