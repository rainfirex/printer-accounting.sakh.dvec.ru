export default {

    state: {

        logs: [],

        countLogs: 0,

        backup: [],

        countPages: 0,

        startPage: 1,

        textFind: '',

        columnFind: 'all',

        events: []

    },

    mutations: {

        setLogs(state, payload) {
            state.logs = payload;
        },

        addLogs(state, payload) {

            for (let log of payload) {
                state.logs.push(log)
            }

        },

        setCountPages(state, payload) {
            state.countPages = payload;
        },

        countPage_decrement(state) {
            state.countPages = state.countPages-1;
        },

        startPage_increment(state) {
            state.startPage = state.startPage+1;
        },

        setTextFind(state, payload) {
            state.textFind = payload;
        },

        setColumnFind(state, payload){
            state.columnFind = payload.target.value;
        },

        setBackup(state, payload) {
            state.backup = payload;
        },

        setEvents(state, payload) {
            state.events = payload;
        },

        setStartPage(state, payload = 1) {
            state.startPage = payload;
        },

        setCountLogs(state, payload) {
            state.countLogs = payload;
        }
    },

    getters: {

        getLogs(state) {
            return state.logs;
        },

        getCountPages(state) {
            return state.countPages;
        },

        getStartPage(state) {
            return state.startPage;
        },

        getTextFind(state) {
            return state.textFind;
        },

        getColumnFind(state){
            return state.columnFind;
        },

        getBackup(state) {
            return state.backup;
        },

        getEvents(state) {
            return state.events;
        },

        getCountLogs(state) { return state.countLogs}
    },

    actions: {

        async loadLogs(context) {
            return await new Promise((resolve, reject) => {

                const countPages =  context.getters.getCountPages;
                const startPage =  context.getters.getStartPage;

                if (startPage > countPages) return;

                axios.get(`/api/log/limit-gets/${startPage}`).then(response => {
                    context.commit('addLogs', response.data.logs);
                    context.commit('startPage_increment');
                    resolve(response);
                }).catch(e => {
                    reject(e);
                });

                // const  logsPage = context.getters.getCountPages;
                // axios.get(`/api/log/limit-gets/${logsPage}`)
                //     .then(response => {
                //         context.commit('countPage_decrement');
                //         context.commit('addLogs', response.data.logs);
                //         resolve(response.data.logs.length);
                //     }).catch(e => {
                //         reject(e);
                //     });
            });
        },

        async loadCountPages(context) {
            return await new Promise((resolve, reject) => {
                axios.get(`/api/log/count-page`).then(response => {
                    context.commit('setCountPages', response.data.count);
                    resolve(response.data.count);
                }).catch(e => {
                    reject(e);
                });
            });
        },

        async findLogs(context) {
            return await new Promise((resolve, reject) => {

                const text = context.getters.getTextFind;
                const column = context.getters.getColumnFind;

                axios.get(`/api/log/find/text/${text}/type/${column}`)
                    .then(response => {

                        const bkp  = context.getters.getBackup;
                        const logs = context.getters.getLogs;

                        if (bkp.length === 0) {
                            context.commit('setBackup', logs);
                        }

                        context.commit('setLogs', response.data.logs);

                    }).catch(e => {
                        reject(e)
                    });
            });
        },

        async loadEvents(context) {
            return await new Promise((resolve, reject) => {
                axios.get(`/api/event/gets`).then(response => {
                    context.commit('setEvents', response.data.events);
                    resolve(response);
                }).catch(e => {
                    reject(e);
                });
            });
        },

        async loadCountLogs(context) {
            return await new Promise((resolve, reject) => {
                axios.get(`/api/log/count-log`).then(response => {
                    context.commit('setCountLogs', response.data.count);
                    resolve(response);
                }).catch(e => {
                    reject(e);
                });
            });
        }
    }

}
