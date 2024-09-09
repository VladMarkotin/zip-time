export default {
    state: {
        windowScreenWidth: window.innerWidth,
    },
    mutations: {
        SET_WINDOW_SCREEN_WIDTH(state, {windowScreenWidth}) {
            state.windowScreenWidth = windowScreenWidth;
        },
    },
    getters: {
        getWindowScreendWidth(state) {
            return state.windowScreenWidth;
        }
    }
}