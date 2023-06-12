import './bootstrap';

import { createApp } from 'vue';
import { createStore } from 'vuex';
import router from './router';
import App from './App.vue';


const store = createStore({
    state() {
        return {
            isLogged: localStorage.getItem('isLogged') === 'true',
            porukaLog: localStorage.getItem('porukaLogiran') || '',

        };
    },
    mutations: {
        setIsLogged(state, value) {
            state.isLogged = value;
            localStorage.setItem('isLogged', value.toString());
        },
        setPorukaLog(state, value) {
            state.porukaLog = value;
            localStorage.setItem('porukaLogiran', value); // Ispravljen ključ u lokalnom spremištu
        },


    },
    actions: {
        login({ commit }) {
            commit('setIsLogged', true);
            commit('setPorukaLog', 'Uspješna prijava!');
            setTimeout(() => {
                commit('setPorukaLog', ''); // Resetiranje poruke nakon 5 sekundi
            }, 1000);// Postavljanje poruke kod prijave
        },
        logout({ commit }) {
            commit('setIsLogged', false);
            commit('setPorukaLog', ''); // Resetiranje poruke kod odjave
        },
        setPoruka({ commit }, poruka) {
            commit('setPorukaLog', poruka);
            setTimeout(() => {
                commit('setPorukaLog', ''); // Resetiranje poruke nakon 5 sekundi
            }, 5000);
        },


    },
    getters: {
        getIsLogged(state) {
            return state.isLogged;
        },
        getPorukaLog(state) {
            return state.porukaLog;
        },

    },
});

const app = createApp(App);

app.use(router);
app.use(store);

app.mount('#app');
