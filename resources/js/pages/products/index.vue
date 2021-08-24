<template>
    <div class="px-56 min-h-screen">
        <!-- TODO: TEMP FIX FOR NAVBAR -->
        <div class="h-20"></div>
        
        <div class="mt-24">
            <h1 class="text-center no-underline text-3xl tracking-tight">Sortiment</h1>
        </div>
            
        <div class="flex">
            
            <div class="flex-none w-52">
                
                <!-- Price -->
                <div>
                    <div class="w-full h-12 border-b-2 border-black flex justify-left items-center" v-on:click="showPriceRange = !showPriceRange">
                        <i :class="{ rotate: showPriceRange }" class="fa fa-arrow-down ml-4 mr-2"></i>
                        <p>Pris</p>
                    </div>
                    <div class="flex flex-col" v-if="showPriceRange">
                        <div class="flex w-full items-center">
                            <input class="w-1/2 ml-4 mr-1 my-4 p-2 bg-gray-200" type="number" v-model="priceRange[0]" :min="0" :max="priceRange[1]" @keyup="controlMinPrice">
                            <span>-</span>
                            <input class="w-1/2 mr-4 ml-1 my-4 p-2 bg-gray-200" type="number" v-model="priceRange[1]" :min="priceRange[0]" :max="maxPrice" @keyup="controlMaxPrice">
                        </div>
                        <div class="p-4 pb-6 pt-2">
                            <vue-slider 
                                v-model="priceRange"
                                :max="maxPrice"
                                :marks="priceMarks"
                                :enable-cross="false"
                                :drag-on-click="true"
                            />
                        </div>
                    </div>
                </div>
                
                <!-- Number of players -->
                <div>
                    <div class="w-full h-12 border-b-2 border-black flex justify-left items-center" @click="showNumberOfPlayers = !showNumberOfPlayers">
                        <i :class="{ rotate: showNumberOfPlayers }" class="fa fa-arrow-down ml-4 mr-2"></i>
                        <p>Antal spelare</p>
                    </div>
                    <div class="flex flex-col" v-if="showNumberOfPlayers">
                        <p>NEED MORE DATA</p>
                        <!-- <div class="flex w-full items-center">
                            <input class="w-1/2 ml-4 mr-1 my-4 p-2 bg-gray-200" type="number" v-model="priceRange[0]" :min="0" :max="priceRange[1]" @keyup="controlMinPrice">
                            <span>-</span>
                            <input class="w-1/2 mr-4 ml-1 my-4 p-2 bg-gray-200" type="number" v-model="priceRange[1]" :min="priceRange[0]" :max="maxPrice" @keyup="controlMaxPrice">
                        </div>
                        <div class="p-4 pb-6 pt-2">
                            <vue-slider 
                                v-model="playerRange"
                                :max="maxPlayers"
                                :marks="playerMarks"
                                :enable-cross="false"
                                :drag-on-click="true"
                            />
                        </div> -->
                    </div>
                </div>
                
                <!-- Categories -->
                <div>
                    <div class="w-full h-12 border-b-2 border-black flex justify-left items-center" @click="showCategories = !showCategories">
                        <i :class="{ rotate: showCategories }" class="fa fa-arrow-down ml-4 mr-2"></i>
                        <p>Kategorier</p>
                    </div>
                    <div class="flex flex-col" v-if="showCategories">
                        <p>NEED MORE DATA</p>
                    </div>
                </div>
                
                <!-- Game length -->
                <div>
                    <div class="w-full h-12 border-b-2 border-black flex justify-left items-center" @click="showGameLength = !showGameLength">
                        <i :class="{ rotate: showGameLength }" class="fa fa-arrow-down ml-4 mr-2"></i>
                        <p>Spellängd</p>
                    </div>
                    <div class="flex flex-col" v-if="showGameLength">
                        <p>NEED MORE DATA</p>
                    </div>
                </div>
                
                <!-- Svårighetsgrad -->
                <div>
                    <div class="w-full h-12 border-b-2 border-black flex justify-left items-center" @click="showDifficulty = !showDifficulty">
                        <i :class="{ rotate: showDifficulty }" class="fa fa-arrow-down ml-4 mr-2"></i>
                        <p>Svårighetsgrad</p>
                    </div>
                    <div class="flex flex-col" v-if="showDifficulty">
                        <p>NEED MORE DATA</p>
                    </div>
                </div>
                
            </div>
            
            <div class="flex-grow ml-5">
                
                <div class="relative">
                    <i class="fa fa-search absolute top-1/2 left-4 transform -translate-y-1/2"></i>
                    <input class="w-full bg-gray-100 p-2 pl-12" placeholder="Sök.." type="text" v-model="search">
                </div>
                
                <div class="flex justify-between my-4">
                    <p><span class="font-bold">{{ filteredProducts.length }}</span> Produkter</p>
                    
                    <div>
                        <select class="bg-gray-100 p-2 text-sm" v-model="sortBy">
                            <option value="a-z">Alfabetiskt, A-Ö</option>
                            <option value="z-a">Alfabetiskt, Ö-A</option>
                            <option value="price">Pris</option>
                        </select>
                    </div>
                </div>
                
                <div class="flex justify-center flex-wrap">
                    <div v-for="(product, i) in filteredProducts" :key="i" class="mx-3.5 flex justify-between items-center w-56 h-80 mb-7 flex-col relative">
                        <div class="bg-gray-200 h-full w-full"></div>
                        <div class="w-full text-center">
                            <div class="py-4">
                                <h4>{{ product.name }}</h4>
                                <p>{{ product.price }} kr</p>
                            </div>
                            <a href="#" class="flex justify-center items-center bg-project w-full text-white text-sm p-2 font-bold uppercase">
                                <i class="fa fa-shopping-cart mr-2"></i> Lägg till
                            </a>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</template>

<script>
import VueSlider from 'vue-slider-component'
import 'vue-slider-component/theme/antd.css'

export default {
    data() {
        return {
            products: [],
            sortBy: 'a-z',
            search: '',
            sizes: [],
            colors: [],
            priceRange: [],
            showPriceRange: false,
            showNumberOfPlayers: false,
            showDifficulty: false,
            showCategories: false,
            showGameLength: false,
        }
    },
    mounted() {
        axios.get('/api/products').then(response => {
            this.products = response.data;
            
            
            // Configure price range slide
            let largestPrice = Math.max(...this.products.map(product => product.price));
            let interval = Math.round(largestPrice / 4);
            this.priceRange = [0, largestPrice];
            this.maxPrice = largestPrice;
            this.priceMarks = [0, largestPrice];
        });
    },
    computed: {
        filteredProducts: function () {
            return this.products.filter((product) => {
                return (this.search.length === 0 || product.name.toLowerCase().includes(this.search.toLowerCase())) &&
                    (product.price >= this.priceRange[0] && product.price <= this.priceRange[1])
            }).sort((a, b) => {
                switch(this.sortBy) {
                    case "price": 
                        return a["price"] > b["price"]
                        break;
                    case "z-a":
                        return -1 * a["name"].toString().toLowerCase().localeCompare(b["name"].toString().toLowerCase());
                        break;
                    case "a-z":
                        return a["name"].toString().toLowerCase().localeCompare(b["name"].toString().toLowerCase());
                        break;
                    default:
                        return a["name"].toString().toLowerCase().localeCompare(b["name"].toString().toLowerCase());
                }
            })
        }
    },
    methods: {
        controlMinPrice: function(e) {
            // Lowest val above highest val
            if(e.target.value > this.priceRange[1])
                this.priceRange.splice(0, 1, this.pricerange[1]);
                
            // Lowest price below 0
            if(e.target.value < 0)
                this.priceRange.splice(0, 1, 0);
        },
        controlMaxPrice: function(e) {
            // Highest val below lowest val
            if(e.target.value < this.priceRange[0])
                this.priceRange.splice(1, 1, this.pricerange[0]);
                
            // Lowest price above max
            if(e.target.value > this.maxPrice)
                this.priceRange.splice(1, 1, this.maxPrice);
        }
    },
    components: {
      VueSlider
    }
}
</script>