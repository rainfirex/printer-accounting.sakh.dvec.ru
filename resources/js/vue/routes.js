import VueRouter from 'vue-router';

import PrinterPage from "./pages/PrinterPage";
import AuthPage from "./pages/AuthPage";
import NotFound from "./pages/404";

export default new VueRouter({
    routes : [
        {
            path: '/', component: PrinterPage, name: 'main', meta: {isAuth: true}
        },
        {
            path: '/auth', component: AuthPage, name: 'auth', meta: {isAuth: false}
        },
        {
            path: '/auth/logout', component: null, name: 'logout', meta: {isAuth: true}
        },
        {
            path: '*', component: NotFound, name: 'not-found', meta: {isAuth: false}
        }
    ], mode: 'history'
});
