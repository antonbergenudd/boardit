<template>
    <div>
        <div>
            <div class="w-full h-12 bg-gray-200 flex justify-left items-center" v-on:click="showPriceRange = !showPriceRange">
                <i class="fa fa-arrow-down ml-4"></i>
                <p>Pris</p>
            </div>
            <div class="flex flex-col" v-if="showPriceRange">
                <div class="flex w-full items-center">
                    <input class="w-1/2 ml-4 mr-1 my-4 p-2 bg-gray-200" type="text" v-model="priceRange[0]">
                    <span>-</span>
                    <input class="w-1/2 mr-4 ml-1 my-4 p-2 bg-gray-200" type="text" v-model="priceRange[1]">
                </div>
                <div class="p-4 pb-6 pt-2">
                    <vue-slider v-model="priceRange"/>
                </div>
            </div>
        </div>
        <div>
            <div class="w-full h-12 bg-gray-200 flex justify-left items-center" v-on:click="showNumberOfPlayers = !showNumberOfPlayers">
                <i class="fa fa-arrow-down ml-4"></i>
                <p>Antal spelare</p>
            </div>
            <div v-if="showNumberOfPlayers">
                <p>PLAYERS</p>
            </div>
        </div>
    </div>
</template>

<script> 
import VueSlider from 'vue-slider-component'
import 'vue-slider-component/theme/antd.css'

export default {
    props: ['priceRange'],
    components: {
      VueSlider
    },
    data() { 
        return {
            showPriceRange: false,
            showNumberOfPlayers: false,
            marks: [0, 25, 50, 75, 100]
        } 
    },
    mounted() {}
}
</script>