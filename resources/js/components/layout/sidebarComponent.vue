<template>
    <div :class="{showSidebar: showSidebar}" class="flex flex-col text-white p-4 fixed transform h-screen -right-full top-0 z-20 bg-project" style="width:400px;">
        <div class="flex flex-none justify-between justify-center items-center">
            <h1 class="tracking-tight text-2xl">Din varukorg</h1>
            <i class="fa fa-close cursor-pointer" @click="$store.commit('toggleSidebar', false)"></i>
        </div>
        
        <hr class="bg-project-dark mb-10"/>
        
        <div class="flex flex-grow flex-col content-between justify-between" v-if="cart.length > 0">
            <div class="flex w-full" v-for="(product, index) in cart" :key="product.id">
                <div class="w-32 h-24 bg-gray-200">
                    <img src="#" alt="">
                </div>
                <div class="w-full ml-4 flex flex-col justify-between">
                    <div>
                        <p class="font-semibold" v-text="product.name"></p>
                        <p>Rental details</p>
                    </div>
                    <div class="flex justify-between items-center w-full">
                        <div class="flex">
                            <button class="px-2 py-1 border border-gray-200" @click="$store.commit('removeFromCart', index)">-</button>
                            <p class="py-1 px-4 border border-gray-200" v-text="product.quantity"></p>
                            <button class="px-2 py-1 border border-gray-200" @click="$store.commit('addToCart', product)">+</button>
                        </div>
                        
                        <p class="font-semibold" v-text="cartLineTotal(product)"></p>
                    </div>
                </div>
            </div>
            
            <div class="inline-block">
                <hr class="bg-project-dark my-10" />
                
                <div>
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl uppercase font-semibold">Delsumma </h2>
                        <span class="text-xl font-semibold" v-text="cartTotal"></span>
                    </div>
                    <p class="text-md opacity-80">Moms och leverans ingår</p>
                    <p class="mt-4 flex items-center">
                        <input type="checkbox" v-model="termsAccepted" :value="termsAccepted"> <span class="ml-2 text-sm">Jag har läst <router-link class="underline text-blue-400" :to="{name: 'general.terms'}" >villkoren</router-link></span>
                    </p>
                </div>
                
                <router-link
                    class="w-full mt-4 flex justify-center items-center uppercase font-semibold bg-project-dark-sm underline-none border-0 py-3 focus:outline-none hover:opacity-70 text-base"
                    tag="button"
                    :disabled="!termsAccepted"
                    :to="{name: 'order.checkout'}">
                    Till kassan <i class="fa fa-arrow-right ml-2"></i>
                </router-link>
            </div>
        </div>
        
        <div v-else>
            <h2>Din varukorg är tom.</h2>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                termsAccepted: false
            }
        },
        methods: {
            formatCurrency(price) {
                price = (price / 100);
                return price.toLocaleString('sv-SE', { style: 'currency', currency: 'SEK' });
            },
            cartLineTotal(item) {
                return this.formatCurrency(item.price * item.quantity);
            }
        },
        computed: {
            showSidebar() {
                return this.$store.state.showSidebar;
            },
            cart() {
                return this.$store.state.cart;
            },
            cartQuantity() {
                return this.$store.state.cart.reduce((acc, item) => acc + item.quantity, 0);
            },
            cartTotal() {
                return this.formatCurrency(this.$store.state.cart.reduce((acc, item) => acc + (item.price * item.quantity), 0));
            }
        },
    }
</script>
