import Vue from 'vue';

const globalHeaderInputKey = 'jheckdoc_global_header_input';

const globalOptions = {
  namespaced: true,
  state: {
    globalHeaderInput: JSON.parse(localStorage.getItem(globalHeaderInputKey)) || [],
    globalParameterInput: {},
  },
  mutations: {
    setGlobalHeaderInput(state, item) {
      const { index, key, value } = item;
      state.globalHeaderInput[index] = { key, value };
    },
    deleteGlobalHeaderInput(state, index) {
      state.globalHeaderInput.splice(index, 1);
    },
    setGlobalParameterInput(state, item) {
      const { key, value } = item;
      Vue.set(state.globalParameterInput, key, value);
    },
  },
  actions: {
    async insertGlobalHeaderInput({ commit, dispatch }, item) {
      commit('setGlobalHeaderInput', item);
      dispatch('saveGlobalHeaderInputInStorage');
    },
    async removeGlobalHeaderInput({ commit, dispatch }, item) {
      commit('deleteGlobalHeaderInput', item);
      dispatch('saveGlobalHeaderInputInStorage');
    },
    async saveGlobalHeaderInputInStorage({ state }) {
      localStorage.setItem(globalHeaderInputKey, JSON.stringify(state.globalHeaderInput));
    },
  },
  getters: {
    getGlobalHeaderInput: (state, getters, rootState) => (index = '') => {
      const headerInput = {};
      for (let i = 0; i < state.globalHeaderInput.length; i += 1) {
        const input = state.globalHeaderInput[i];
        headerInput[input.key] = input.value;
      }

      if (index) {
        return typeof headerInput[index] !== 'undefined' ? headerInput[index] : '';
      }

      return headerInput;
    },
  },
};

export default globalOptions;
