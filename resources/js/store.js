import Vuex from 'vuex';
import Vue from 'vue';

Vue.use(Vuex);

export const store = new Vuex.Store({
  state: () => ({
    errors: false,
    success: false,
    token: localStorage.getItem('user-token'),
    showInstallMessage :false,
  }),
  computed: {
    token: function(){
      return localStorage.getItem('user-token');
    }
  }

})