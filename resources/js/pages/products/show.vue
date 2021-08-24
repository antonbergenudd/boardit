<template>
    <section class="text-gray-700 body-font overflow-hidden" v-if="product">
        <div class="container px-12 py-24 mx-auto">
            <div class="lg:w-3/5 mx-auto flex flex-wrap">
                <img class="lg:w-1/2 w-full lg:h-auto h-64 object-cover object-center rounded" src="https://via.placeholder.com/640" alt="">
                <div class="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">
                    <h2 class="text-sm title-font text-gray-500 tracking-widest uppercase inline-block mr-2"
                        v-for="category in product.categories"
                        v-text="category.name"></h2>
                    <h1 class="text-gray-900 text-3xl title-font font-medium mb-2" v-text="product.name"></h1>
                    <p class="leading-relaxed" v-text="product.description"></p>
                    <div class="flex mt-6 pt-4 border-t-2 border-gray-200">
                        <div class="flex flex-col">
                            <span class="title-font font-medium text-2xl text-gray-900" v-text="formatCurrency(product.price)"></span>
                            <span class="font-small text-xs text-gray-400">Moms och leverans ingår</span>
                        </div>
                        <button 
                            class="flex ml-auto uppercase font-semibold items-center rounded text-white bg-project border-0 py-2 px-6 focus:outline-none hover:opacity-50" 
                            @click="$store.commit('addToCart', product)">
                            Lägg till
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="flex justify-center items-center">
            <h1>Recensioner</h1>
        </div>
        
        <div class="flex justify-center items-center">
            <h1>Förslag</h1>
        </div>
    </section>
</template>

<script>
export default {
    methods: {
        formatCurrency(price) {
            price = (price / 100);
            return price.toLocaleString('se-SV', { style: 'currency', currency: 'SEK' });
        }
    },
    computed: {
        products() {
            return this.$store.state.products;
        },
        product() {
            return this.products.find(product => product.slug === this.$route.params.slug);
        }
    }
}
</script>