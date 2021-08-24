<template>
    <div class="w-full min-h-screen flex">
        <div class="w-7/12 py-20 pl-40 pr-20">
            
            <!-- Logo -->
            <router-link :to="{name: 'index'}">
                <img class="w-60" src="/images/logos/logo_black.png" alt="">
            </router-link>
            
            <!-- Breadcrumbs -->
            <p class="text-xs"><span class="text-project">Varukorg</span> > <span class="text-project">Information</span> > <span class="text-project">Frakt</span> > <span class="font-semibold">Betalning</span></p>
            
            <!-- Delivery -->
            <div class="mt-6">
                <div class="flex flex-col items-center justify-center mt-2 border border-gray-300 rounded-md w-full">
                    <div class="flex justify-between items-center p-4 w-full">
                        <div class="flex">
                            <p class="mr-4 text-sm text-gray-600">Kontakta</p>
                            <p>{stored email}</p>
                        </div>
                        <p class="text-sm text-project">ändra</p>
                    </div>
                    
                    <hr class="w-11/12" />
                    
                    <div class="flex justify-between items-center p-4 w-full">
                        <div class="flex">
                            <p class="mr-4 text-sm text-gray-600">Skicka till</p>
                            <p>{stored address}</p>
                        </div>
                        <p class="text-sm text-project">ändra</p>
                    </div>
                    
                    <hr class="w-11/12" />
                    
                    <div class="flex items-center p-4 w-full">
                        <div class="flex">
                            <p class="mr-4 text-sm text-gray-600">Metod</p>
                            <p>{stored method}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Payment -->
            <div class="mt-6">
                <div class="mb-4">
                    <p class="text-lg tracking-tight">Fraktmetod</p>
                    <p class="text-sm">Alla transaktioner är säkra och krypterade.</p>
                </div>
                
                <div class="flex flex-col mt-2 border border-gray-300 rounded-md w-full">
                    <div class="flex justify-between items-center p-4">
                        <label>
                            <input class="opacity-50" type="radio" value="card" v-model="order.payment_method">
                            Kreditkort
                        </label>
                    </div>
                    
                    <hr class="w-full">
                    
                    <div v-show="order.payment_method === 'card'" class="bg-gray-100 p-4 flex flex-col w-full">
                        <div class="mb-4">
                            <input placeholder="Mobilnummer" class="text-xs border border-gray-300 rounded-md focus:border-project p-3 w-full" v-model="order.phone">
                            <p class="text-sm">Vi kan använda detta nummer för att ringa eller sms:a om din leverans.</p>
                        </div>
                        
                        <div>
                            <input placeholder="Leveransinstruktioner (valfritt)" class="text-xs border border-gray-300 rounded-md focus:border-project p-3 w-full" v-model="order.instructions">
                            <p class="text-sm">Ange nödvändig information som portkod eller instruktioner för paketavlämning.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Payment adress -->
            <div class="mt-6">
                <div class="mb-4">
                    <p class="text-lg tracking-tight">Fakturering</p>
                    <p class="text-sm">Välj den adress som matchar ditt kort eller betalningsmetod.</p>
                </div>
                
                <div class="flex flex-col mt-2 border border-gray-300 rounded-md w-full">
                    <div class="flex items-center p-4">
                        <label>
                            <input class="opacity-50" type="radio" value="same" v-model="order.delivery_adress">
                            Samma som leveransadress
                        </label>
                    </div>
                    
                    <hr class="w-full">
                    
                    <div class="flex items-center p-4">
                        <label>
                            <input class="opacity-50" type="radio" value="other" v-model="order.delivery_adress">
                            Använd en annan faktureringsadress
                        </label>
                    </div>
                </div>
            </div>
            
            <!-- Next -->
            <!-- <div class="mt-6">
                <button type="button" @click="processPayment" :disabled="paymentProcessing" v-text="paymentProcessing ? 'Processing' : 'Betala nu'"class="px-4 py-6 text-center bg-project"></button>
            </div> -->
            
            <!-- Temp -->
            <!-- Next -->
            <div class="mt-12">
                <router-link :to="{name:'order.summary'}" class="p-4 py-6 bg-project">Betala nu</router-link>
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
export default {
    data() {
        return {
            stripe: {},
            cardElement: {},
            order: {
                delivery: 'home',
                delivery_method: 'locally',
                delivery_adress: 'same',
                discount_code: '',
                payment_method: 'card',
                phone: '',
                instructions: '',
            },
            customer: {
                first_name: '',
                last_name: '',
                email: '',
                address: '',
                city: '',
                zip_code: '',
                phone: ''
            },
            paymentProcessing: false,
        }
    },
    async mounted() {
        this.stripe = await loadStripe(process.env.MIX_STRIPE_KEY);
        
        const elements = this.stripe.elements();
        this.cardElement = elements.create('card', {
            classes: {
                base: 'bg-gray-100 rounded border border-gray-300 focus:border-indigo-500 text-base outline-none text-gray-700 p-3 leading-8 transition-colors duration-200 ease-in-out',
            }
        });
        
        this.cardElement.mount('#card-element');
    },
    methods: {
        cartLineTotal(item) {
            let price = item.price * item.quantity;
            price = price / 100;
            
            return price.toLocaleString('sv-SE', { style: 'currency', currency: 'SEK' });
        },
        async processPayment() {
            this.processingPayment = true;
            
            const {paymentMethod, error} = await this.stripe.createPaymentMethod(
                'card', this.cardElement, {
                    billing_details: {
                        name: this.customer.first_name + ' ' + this.customer.last_name,
                        email: this.customer.email,
                        address: {
                            line1: this.customer.address,
                            city: this.customer.city,
                            state: this.customer.state,
                            postal_code: this.customer.zip_code
                        }
                    }
                }
            );
            
            if(error) {
                console.log(error);
                this.paymentProcessing = false;
                alert(error);
            } else {
                this.customer.payment_method_id = paymentMethod.id;
                this.customer.amount = this.cart.reduce((acc, item) => acc + (item.price * item.quantity), 0);
                this.customer.cart = JSON.stringify(this.cart);
                
                axios.post('/api/purchase', this.customer).then(response => {
                    this.paymentProcessing = false;
                    
                    this.$store.commit('updateOrder', response.data);
                    this.$store.dispatch('clearCart');
                    
                    this.$router.push({ name: 'order.summary' });
                }).catch(error => {
                    console.log(error);
                    this.paymentProcessing = false;
                    alert(error);
                })
            }
        }
    },
    computed: {
        cart() {
            return this.$store.state.cart;
        },
        cartQuantity() {
            return this.$store.state.cart.reduce((acc, item) => acc + item.quantity, 0);
        },
        cartTotal() {
            let price = this.$store.state.cart.reduce((acc, item) => acc + (item.price * item.quantity), 0);
            price = price / 100;
            
            return price.toLocaleString('sv-SE', { style: 'currency', currency: 'SEK' });
        }
    }
}
</script>