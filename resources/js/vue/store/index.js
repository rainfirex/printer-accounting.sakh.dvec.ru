import Vue from 'vue';
import Vuex from 'vuex'

import Auth from "./modules/Auth";
import Navs from "./modules/Navs";
import Devices from "./modules/Devices";
import Logs from "./modules/Logs";

Vue.use(Vuex);

const store  = new Vuex.Store({
    modules: {
        Auth,
        Navs,
        Devices,
        Logs
    }
});

export default store
