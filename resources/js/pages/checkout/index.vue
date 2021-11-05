<template>
    <div class="w-full min-h-screen flex">
        <div class="w-7/12 py-20 pl-40 pr-20">
            
            <!-- Logo -->
            <router-link :to="{name: 'index'}">
                <img class="w-60" src="/images/logos/logo_black.png" alt="">
            </router-link>
            
            <!-- Breadcrumbs -->
            <p class="text-xs"><span class="text-project">Varukorg</span>  >  <span class="font-semibold">Information</span>  >  Frakt  >  Betalning</p>
            
            <!-- Fast checkout -->
            <div class="relative mt-6 w-full h-20 border border-gray-300 rounded-md">
                <p class="absolute -top-2.5 left-1/2 transform -translate-x-1/2 bg-white px-2">Snabbkassa</p>
            </div>
            
            <!-- Divider -->
            <div class="relative mt-6 w-full h-1 border-t-2 border-gray-300">
                <p class="uppercase text-xs text-gray-800 absolute -top-2.5 left-1/2 transform -translate-x-1/2 bg-white px-2">eller</p>
            </div>
            
            <!-- Contact -->
            <div class="mt-6">
                <p class="text-lg mb-2 font-medium">Kontaktinformation</p>
                <input placeholder="E-postadress eller mobilnummer" class="text-xs border border-gray-300 rounded-md focus:border-project p-3 w-full" v-model="order.customer.email">
            </div>
            
            <!-- Delivery -->
            <div class="mt-6">
                <p class="text-lg mb-2 font-medium">Leveransmetod</p>
                <div class="mt-2 border border-gray-300 rounded-md w-full">
                    <div class="flex items-center border-b-2 border-gray-300 p-4 w-full">
                        <label>
                            <input class="opacity-50" type="radio" v-model="order.delivery">
                            <i class="mx-2 fa fa-truck"></i>
                            Hemleverans
                        </label>
                    </div>
                    <div class="flex items-center p-4 w-full">
                        <label>
                            <input class="opacity-50" type="radio" v-model="order.delivery">
                            <i class="mx-2 fa fa-home"></i>
                            Hämta
                        </label>
                    </div>
                </div>
            </div>
            
            <!-- Adress -->
            <div class="mt-6">
                <p class="text-lg mb-2 font-medium">Leveransadress</p>
                <input placeholder="Förnamn" class="text-xs border border-gray-300 mb-4 rounded-md focus:border-project p-3 w-full" v-model="first_name">
                <input placeholder="Efternamn" class="text-xs border border-gray-300 mb-4 rounded-md focus:border-project p-3 w-full" v-model="last_name">
                <input placeholder="Gatuadress och husnummer" class="text-xs border border-gray-300 mb-4 rounded-md focus:border-project p-3 w-full" v-model="address">
                <input placeholder="Postnummer" class="text-xs border border-gray-300 mb-4 rounded-md focus:border-project p-3 w-full" v-model="order.customer.zip_code">
                <input placeholder="Stad/ort" class="text-xs border border-gray-300 mb-4 rounded-md focus:border-project p-3 w-full" v-model="order.customer.city">
                <input placeholder="Telefon (valfritt)" class="text-xs border border-gray-300 mb-4 rounded-md focus:border-project p-3 w-full" v-model="order.customer.phone">
                <label class="mb-2">
                    <input type="checkbox" v-model="order.customer.save_info">
                    Spara den här informationen för nästa gång
                </label>
                <!-- <input placeholder="Land/Region" class="border border-gray-300 rounded-md focus:border-project p-2 w-full" v-model="customer.country"> -->
            </div>
            
            <!-- Next -->
            <div class="mt-12">
                <router-link :to="{name:'order.delivery'}" class="p-4 py-6 bg-project">Fortsätt till leverans</router-link>
            </div>
        </div>
        
        <div class="w-5/12 min-h-screen bg-project-light-sm pr-40 pl-10 py-20">
            
            <!-- Products -->
            <div v-for="(product, index) in cart">
                <div class="flex justify-between w-full mb-8">
                    <div class="flex items-center">
                        <img class="w-14 h-14 bg-gray-200 border-xl border-gray-200 mr-4" src="#" alt="">
                        <div class="flex flex-col">
                            <p class="text-sm font-semibold" v-text="product.name"></p>
                            <p class="text-sm">Rental details</p>
                            <p class="text-sm">Rental details</p>
                            <p class="text-sm">Rental details</p>
                            <p class="text-sm">Rental details</p>
                        </div>
                    </div>
                    
                    <p class="text-sm text-right flex justify-center items-center font-semibold" v-text="cartLineTotal(product)"></p>
                </div>
                
                <hr class="mb-6 border-gray-200" />
            </div>
            
            <!-- Discount -->
            <div class="mb-6 flex">
                <input placeholder="E-postadress eller mobilnummer" class="border-2 border-gray-300 flex-grow mr-2 text-xs rounded-md focus:border-project p-3" v-model="order.discount_code">
                <button type="button" class="p-4 rounded-md bg-gray-400">Tillämpa</button>
            </div>
            
            <hr class="mb-6 border-gray-200" />
            
            <div class="mb-6">
                <div class="flex justify-between mb-4">
                    <p>Delsumma</p>
                    <p v-text="cartTotal"></p>
                </div>
                <div class="flex justify-between">
                    <p>Frakt</p>
                    <p>Ingår</p>
                </div>
            </div>
            
            <hr class="mb-6 border-gray-200" />
            
            <div class="mb-6">
                <div class="flex justify-between items-center">
                    <p>Totalt</p>
                    <p class="text-2xl font-semibold" v-text="cartTotal"></p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { loadStripe } from '@stripe/stripe-js';
import { mapState } from "vuex";
export default {
    data() {
        return {
            stripe: {},
            cardElement: {},
            paymentProcessing: false,
        }
    },
    methods: {
        cartLineTotal(item) {
            let price = item.price * item.quantity;
            price = price / 100;
            
            return price.toLocaleString('sv-SE', { style: 'currency', currency: 'SEK' });
        },
    },
    computed: {
        ...mapState(["order"]),
        first_name: {
            set(first_name) {
                this.$store.commit("setOrder", { customer: { first_name } });
            },
            get() {
                return this.order.customer.first_name;
            }
        },
        last_name: {
            set(last_name) {
                this.$store.commit("setOrder", { customer: { last_name } });
            },
            get() {
                return this.order.customer.last_name;
            }
        },
        address: {
            set(address) {
                this.$store.commit("setOrder", { customer: { address } });
            },
            get() {
                return this.order.customer.address;
            }
        },
        cart() {
            return this.$store.state.cart;
        },
        cartTotal() {
            let price = this.$store.state.cart.reduce((acc, item) => acc + (item.price * item.quantity), 0);
            price = price / 100;
            
            return price.toLocaleString('sv-SE', { style: 'currency', currency: 'SEK' });
        }
    }
}
</script>