import Vue from 'vue'
import Vuex from 'vuex'

import App from './pages/app'
import Index from './pages/index'
import Products from './pages/products/index'
import ProductInfo from './pages/products/show'
import Checkout from './pages/checkout/index'
import Delivery from './pages/checkout/delivery'
import Payment from './pages/checkout/payment'
import Summary from './pages/checkout/summary'
import TermsAndCondition from './pages/termsAndCondition'

import VueRouter from 'vue-router'
import * as VueGoogleMaps from 'vue2-google-maps'
import createPersistedState from "vuex-persistedstate";

// Layout components
Vue.component('navbar-component', require('./components/layout/navbarComponent.vue').default);
Vue.component('footer-component', require('./components/layout/footerComponent.vue').default);
Vue.component('sidebar-component', require('./components/layout/sidebarComponent.vue').default);
Vue.component('chat-support-component', require('./components/common/chatSupportComponent.vue').default);

// Pages
// Vue.component('search-bar-component', require('./pages/products/components/searchBarComponent.vue').default);

Vue.use(Vuex)
Vue.use(VueRouter);
Vue.use(VueGoogleMaps, {
  load: {
    key: 'AIzaSyBe__mmTgHFrkGO0z7Bh8pRMOpZwe10d38',
    libraries: 'places',
  }
});

const router = new VueRouter({
    mode: 'history',
    linkExactActiveClass: 'is-active',
    routes: [
        {
            path: '/',
            name: 'index',
            component: Index
        },
        {
            path: '/products',
            name: 'products',
            component: Products
        },
        {
            path: '/product/:slug',
            name: 'products.show',
            component: ProductInfo
        },
        {
            path: '/checkout',
            name: 'order.checkout',
            component: Checkout
        },
        {
            path: '/checkout/delivery',
            name: 'order.delivery',
            component: Delivery
        },
        {
            path: '/checkout/payment',
            name: 'order.payment',
            component: Payment
        },
        {
            path: '/checkout/summary',
            name: 'order.summary',
            component: Summary
        },
        {
            path: '/terms-and-condition',
            name: 'general.terms',
            component: TermsAndCondition
        },
    ],
});

const store = new Vuex.Store({
    plugins: [createPersistedState({
        storage: window.sessionStorage,
    })],
    state: {
        products: [],
        cart: [],
        order: {
            customer: {
                first_name: '',
                last_name: '',
                address: '',
                zip_code: '',
                city: '',
                phone: '',
            },
            delivery: "home",
            save_info: false
        },
        showSidebar: false
    },
    mutations: {
        updateProducts(state, products) {
            state.products = products;
        },
        addToCart(state, product) {
            let productInCartIndex = state.cart.findIndex(item => item.slug === product.slug);
            
            if(productInCartIndex !== -1) {
                state.cart[productInCartIndex].quantity++;
                return;
            }
            
            product.quantity = 1;
            
            state.cart.push(product);
        },
        removeFromCart(state, index) {
            if(state.cart[index].quantity > 1) {
                state.cart[index].quantity--;
            } else {
                state.cart.splice(index, 1);
            }
        },
        updateOrder(state, order) {
            state.order = order;
        },
        updateCart(state, cart) {
            state.cart = cart;
        },
        toggleSidebar(state, showSidebar) {
            state.showSidebar = showSidebar;
        },
        setOrder(state, values) {
            console.log(state.order);
            console.log(values);
            console.log( Object.assign({}, state.order, values));
          state.order = Object.assign({}, state.order, values);
        }
    },
    actions: {
        getProducts({ commit }) {
            axios.get('/api/products').then(response => {
                commit('updateProducts', response.data)
            }).catch(error => console.error(error));
        },
        clearCart({ commit }) {
            commit('updateCart', []);
        }
    }
});

const app = new Vue({
    el: '#app',
    components: { App },
    watch:{
        $route (to, from){
            this.$store.state.showSidebar = false;
        }
    },
    router,
    store,
    created() {
        store.dispatch('getProducts').then(_ => {})
            .catch(error => console.error(error));
    }
});
