import Vue from 'vue/dist/vue.esm.js';
import VeeValidate from 'vee-validate';
import VueDraggable from 'vuedraggable';

window.Vue = Vue;

Vue.component('draggable', VueDraggable);
Vue.use(VeeValidate);