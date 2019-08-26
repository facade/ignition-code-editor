import Toasted from 'vue-toasted';

Ignition.registerTab((Vue) => {
    Vue.use(Toasted);

    Vue.component('StackTab', require('./components/tabs/StackTab').default);
});