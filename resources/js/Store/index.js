import Vue from 'vue';
import Vuex from 'vuex'

Vue.use(Vuex);

const store = new Vuex.Store({
  state: {
    count: 0,
    user: JSON.parse(localStorage.getItem('user')) || null,
    token: localStorage.getItem('token') || null,
    wallet: JSON.parse(localStorage.getItem('wallet')) || null,
    userData: JSON.parse(localStorage.getItem('userData')) || null
  },
  mutations: {
    SET_AUTH(state, payload) {
      state.user = payload.user
      state.token = payload.token
      localStorage.setItem('user', JSON.stringify(payload.user));
      localStorage.setItem('token', payload.token);
    },
    SET_WALLET(state, payload) {
      state.wallet = payload
      localStorage.setItem('wallet', JSON.stringify(payload))
    },
    SET_USER_DATA(state, payload) {
      state.userData = payload
      localStorage.setItem('userData', JSON.stringify(payload));
    },
    CLEAR_AUTH(state) {
      state.user = null
      state.token = null
      localStorage.clear();
    }
  },
  actions: {
    registerUser({ commit }, payload) {
      return axios.post('/auth/register', payload)
        .then((res) => {
          const { data } = res;
          commit('SET_AUTH', data);
          return res
        })
        .catch((e) => {
          return e;
        })
    },
    loginUser({ commit }, payload) {
      return axios.post('/auth/login', payload)
        .then((res) => {
          const { data } = res;
          commit('SET_AUTH', data);
          return res.data;
        })
        .catch((e) => {
          return e;
        })
    },
    addIdCard({ commit }, { token, ...payload}) {
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
      return axios.post('/app/id', payload)
        .then((res) => {
          return res.data;
        })
        .catch((e) => {
          return e;
        })
    },
    getWallet({ commit }, token) {
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
      return axios.get('app/wallet')
        .then((res) => {
          const { data } = res.data;
          commit('SET_WALLET', data);
          return data
        })
        .catch((e) => {
          return e
        })
    },
    transfer(_, payload) {
      axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('token')}`;
      return axios.post('app/transfer', payload)
        .then((res) => {
          console.log(res);
          return res.data
        })
        .catch((e) => {
          return e
        })
    },
    getUserData({ commit }, token) {
      axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
      return axios.get('app/user')
        .then((res) => {
          const { data } = res.data;
          commit('SET_USER_DATA', data);
          return data
        })
        .catch((e) => {
          return e
        })
    }
  }
})

export default store;
