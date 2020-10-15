export default {

    state: {
        device: {
            id: null,
            product: null,
            model: null,
            serial: null,
            location: null,
            cartridge: null,
            mac: null,
            inventory: null,
            username: null,
            cabinet: null
        },

        currentIndexDevice: null,

        currentDevice: null,

        devices: [],

        backupDevices: []
    },

    mutations: {
        setDevices(state, payload) {
            state.devices = payload;
        },

        addDevice(state, payload) {
            state.devices.unshift(payload);
        },

        editDevice(state, payload) {
            state.devices[payload.deviceIndex] = payload.device;
        },

        removeDevice(state, payload) {
            state.devices.splice(payload, 1);
        },

        backupDevices(state) {
            if (state.backupDevices.length === 0) {
                state.backupDevices = state.devices;
            }
        },

        loadBackupDevices(state) {
            if (state.backupDevices.length > 0) {
                state.devices = state.backupDevices;
                state.backupDevices = [];
            }
        },

        resetBackupDevices(state) {
            state.backupDevices = [];
        },

        setCurrentDevice(state, payload) {
            state.currentDevice = payload;
        },

        setCurrentIndexDevice(state, payload) {
            state.currentIndexDevice = payload;
        }
    },

    getters: {
        getCurrentIndexDevice(state) {
            return state.currentIndexDevice;
        },

        getCurrentDevice(state) {
            return state.currentDevice;
        },

        getDevices(state) {
            return state.devices;
        }
    },

    actions: {
        async loadDevices(context, page = 1) {
           return await new Promise((resolve, reject) => {
                axios.get(`/api/device/gets/${page}`)
                    .then(response => {
                        context.commit('setDevices', response.data.printers);
                        resolve({paginationCount: response.data.pagination});
                    })
                    .catch(e => {
                        reject(e);
                    })
            });
        },

        async addDevice(context, formData) {
            return await new Promise((resolve, reject) => {
                axios.post(`/api/device/add`, formData)
                    .then(response => {

                        if (response.data.result)
                            context.commit('addDevice', response.data.printer);

                        resolve({result:response.data.result})
                    })
                    .catch(e => {
                        reject(e);
                    })
            });
        },

        async editDevice(context, object) {
            return await new Promise((resolve, reject) => {

                const {deviceId, formData, deviceIndex } = object;

                axios.post(`/api/device/edit/${deviceId}`, formData).then(response => {

                    if (response.data.result)
                        context.commit('editDevice', {device: response.data.printer, deviceIndex:deviceIndex});

                    resolve(response.data);
                }).catch(e => {
                    reject(e);
                })
            });
        },

        async removeDevice(context, object) {
            return await new Promise((resolve, reject) => {

                const { deviceId, deviceIndex } = object;

                axios.delete(`/api/device/remove/${deviceId}`).then(response => {

                    if (response.data.result) {
                        context.commit('removeDevice', deviceIndex);
                    }

                    resolve(response.data);
                }).catch(e => {
                    reject(e);
                })
            });
        },

        async findDevice(context, object) {
            return await new Promise((resolve, reject) => {

                const { text, column } = object;

                axios.get(`/api/device/find/${text}/column/${column}`).then(response => {

                    context.commit('backupDevices');
                    context.commit('setDevices', response.data.printers);

                    resolve(response.data);
                }).catch(e => {
                    reject(e);
                });
            });
        },

        loadBackupDevices(context) {
            context.commit('loadBackupDevices');
        }
    }
}
