import router from "../../routes";

export default {

    state: {

        user: {
            user_id: null,
            api_token: null,
            name: null,
            email: null,
            phone: null,
            mobile: null,
            department: null,
            title: null,
            last_ip: null,
            user_agent: null,
            is_handler: false,
            auth: false
        }

    },

    mutations: {

        login(state, data) {
            localStorage.setItem('user_id', data.user_id);
            localStorage.setItem('api_token', data.api_token);
            localStorage.setItem('name', data.name);
            localStorage.setItem('email', data.email);
            localStorage.setItem('phone', data.phone);
            localStorage.setItem('mobile', data.mobile);
            localStorage.setItem('department', data.department);
            localStorage.setItem('title', data.title);
            localStorage.setItem('last_ip', data.last_ip);
            localStorage.setItem('user_agent', data.user_agent);
            localStorage.setItem('is_handler', data.is_handler);
        },

        logout(state) {
            localStorage.removeItem('user_id');
            localStorage.removeItem('api_token');
            localStorage.removeItem('name');
            localStorage.removeItem('email');
            localStorage.removeItem('phone');
            localStorage.removeItem('mobile');
            localStorage.removeItem('department');
            localStorage.removeItem('title');
            localStorage.removeItem('last_ip');
            localStorage.removeItem('user_agent');
            localStorage.removeItem('is_handler');

            state.user = {
                user_id: null,
                api_token: null,
                name: null,
                email: null,
                phone: null,
                mobile: null,
                department: null,
                title: null,
                last_ip: null,
                user_agent: null,
                is_handler: false,
                auth: false
            };
        },

        initUser(state) {
            state.user.user_id    = localStorage.getItem('user_id');
            state.user.api_token  = localStorage.getItem('api_token');
            state.user.name       = localStorage.getItem('name');
            state.user.email      = localStorage.getItem('email');
            state.user.phone      = localStorage.getItem('phone');
            state.user.mobile     = localStorage.getItem('mobile');
            state.user.department = localStorage.getItem('department');
            state.user.title      = localStorage.getItem('title');
            state.user.last_ip    = localStorage.getItem('last_ip');
            state.user.user_agent = localStorage.getItem('user_agent');
            state.user.is_handler = localStorage.getItem('is_handler');

            state.user.auth = state.user.user_id !== null &&
                            state.user.api_token !== null &&
                            state.user.name !== null;

            //Токен авторизации api
            const token = state.user.api_token;
            const auth = state.user.auth;

            if (token && auth) {
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
            }
        }
    },

    getters: {
        getUser(state) {
            return state.user;
        }
    },

    actions: {
        async login(context, user) {
            return await new Promise((resolve, reject) => {
                axios.post(`/api/auth/login`, user).then(response => {

                    if (response.data.success) {
                        context.commit('login', response.data);
                        context.commit('initUser');
                        router.push('/');
                    }

                    resolve(response)
                }).catch(e => {
                    reject(e)
                });
            });
        },

        async logout(context) {
            return await new Promise((resolve, reject) => {
                axios.post(`/api/auth/logout`).then(response => {

                    context.commit('logout');
                    router.push('/auth');

                    if (response.data.success) { }

                    resolve(response);
                }).catch(e => {
                    reject(e);
                });
            });
        }
    }
}
