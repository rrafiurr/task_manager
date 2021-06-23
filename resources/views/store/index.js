import { createStore } from 'vuex'
import createPersistedState from "vuex-persistedstate";

export default createStore({
  plugins: [createPersistedState()],
  state:{
      toDo:[],
      inPogress:[],
      doneTask:[],
      callSave:0,

  },
  mutations: {
    toDoUpdate (state, payload) {
      state.toDo = payload
    },
    inPogressUpdate (state, payload) {
      state.inPogress = payload
    },
    doneTaskdate (state, payload) {
      state.doneTask = payload
    },
    callSave (state) {
      state.callSave++
    }
  },
  actions: {
  },
  modules: {
  }
})
