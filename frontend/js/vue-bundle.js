import Vue from 'vue';
window.Vue = Vue;

import axios from 'axios';
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
const csrfToken = document.querySelector("meta[name=csrf-token]").content;
axios.defaults.headers.post['X-CSRF-Token'] = csrfToken;

import Component from './vue/component.vue'

new Vue({
    el: '.vue-component',
    render: function(h) {
        const data = this.$el.dataset;
        return h(Component, {
            attrs: {data},
        });
    },
})