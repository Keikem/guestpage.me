import Vue from 'vue'
import Vuex from 'vuex'

import { login, register, me, logout } from './utils/api'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        status: '',
        token: localStorage.getItem('token') || '',
        user: JSON.parse(localStorage.getItem('user')) || {}
    },
    mutations: {
        auth_request(state) {
            state.status = 'loading'
        },
        auth_success(state, token) {
            state.status = 'success'
            state.token = token
            localStorage.setItem('token', token)
        },
        user_info(state, user) {
            state.user = user
            localStorage.setItem('user', JSON.stringify(user))
        },
        auth_error(state) {
            state.status = 'error'
            state.token = ''
            state.user = {}
            localStorage.removeItem('token')
            localStorage.removeItem('user')
        },
        logout(state) {
            state.status = ''
            state.token = ''
            state.user = {}
            localStorage.removeItem('token')
            localStorage.removeItem('user')
        }
    },
    actions: {
        login({ commit }, user) {
            return new Promise((resolve, reject) => {
                commit('auth_request')
                login(user).then(response => {
                    const token = response.data.access_token
                    commit('auth_success', token)
                    resolve(response)
                }).catch(err => {
                    commit('auth_error')
                    reject(err.response.data)
                })
            })
        },
        register({ commit }, newUser) {
            return new Promise((resolve, reject) => {
                commit('auth_request')
                register(newUser).then(response => {
                    const token = response.data.access_token
                    commit('auth_success', token)
                    resolve(response)
                }).catch(err => {
                    commit('auth_error')
                    reject(err.response.data)
                })
            })
        },
        me({ commit, state }) {
            return new Promise((resolve, reject) => {
                me(state.token).then(response => {
                    const user = response.data
                    commit('user_info', user)
                    resolve(response)
                }).catch(err => {
                    reject(err)
                })
            })
        },
        logout({ commit, state }) {
            return new Promise(() => {
                logout(state.token).then().finally(() => {
                    commit('logout')
                })
            })
        }
    },
    getters: {
        currentStatus: state => state.status,
        isLogged: state => !!state.token,
        isAdmin: state => state.user.role === "2"
    },
})