import Vue from 'vue';
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
	state: {
	    items: [],
	},
	mutations: {
	    setItems (items) {
		    state.items = items;
	    }
	}
});

export default store;