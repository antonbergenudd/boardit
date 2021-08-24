<template>
    <div class="w-full min-h-screen flex">
        <div class="w-7/12 py-20 pl-40 pr-20">
            
            <!-- Logo -->
            <router-link :to="{name: 'index'}">
                <img class="w-60" src="/images/logos/logo_black.png" alt="">
            </router-link>
            
            <div class="">
                Validating order...
            </div>
            
            <div class="">
                Order details...
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
            
            <!-- Total -->
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
export default {
    computed: {
        order() {
            return this.$store.state.order;
        },
        orderQuantity() {
            return this.$store.state.order.products.reduce((acc, item) => acc + item.pivot.quantity, 0);
        },
        orderTotal() {
            let price = this.$store.state.order.products.reduce((acc, item) => acc + (item.price * item.pivot.quantity), 0);
            price = price / 100;
            
            return price.toLocaleString('sv-SE', { style: 'currency', currency: 'SEK' });
        },
        cart() {
            return this.$store.state.cart;
        },
        cartTotal() {
            let price = this.$store.state.cart.reduce((acc, item) => acc + (item.price * item.quantity), 0);
            price = price / 100;
            
            return price.toLocaleString('sv-SE', { style: 'currency', currency: 'SEK' });
        }
    },
    methods: {
        cartLineTotal(item) {
            let price = item.price * item.quantity;
            price = price / 100;
            
            return price.toLocaleString('sv-SE', { style: 'currency', currency: 'SEK' });
        },
    }
}
</script>