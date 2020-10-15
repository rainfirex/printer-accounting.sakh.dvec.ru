export default {
    state: {
        navs: [
            {path: '/', title: 'Главная', auth: 'both', is_handler: false},
            {path: '/auth', title: 'Авторизация', auth: false, is_handler: false},
            {path: '/auth/logout', title: 'Выход', auth: true, is_handler: false}
        ]
    },

    getters: {
        getNavs(state){
            return state.navs;
        }
    }
}
