import './bootstrap';

import { createApp } from 'vue';
import { createStore } from 'vuex';
import router from './router';
import App from './App.vue';

const store = createStore({
  state() {
    return {
      isLogged: localStorage.getItem('isLogged') === 'true',
    };
  },
  mutations: {
    setIsLogged(state, value) {
      state.isLogged = value;
      localStorage.setItem('isLogged', value.toString());
    },
  },
  actions: {
    login({ commit }) {
      commit('setIsLogged', true);
    },
    logout({ commit }) {
      commit('setIsLogged', false);
    },
  },
  getters: {
    getIsLogged(state) {
      return state.isLogged;
    },
  },
});

const app = createApp(App);

app.use(router);
app.use(store);

app.mount('#app');
