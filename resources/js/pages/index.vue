<template>
    <div>        
        <div class="h-screen items-center justify-center flex text-white" style="background:url('/images/playing-card-games-at-a-table.jpg') rgba(0, 0, 0, 0.3); background-position: center; background-repeat: no-repeat; background-size: cover; background-blend-mode: multiply;">
            <div class="text-center">
                <p class="font-semibold">Hyr brädspel hem till dörren</p>
                <h1 class="text-6xl">Upptäck dina favoriter</h1>
                <a href="#" class="button py-4 px-8 inline-block no-underline font-semibold mt-4 bg-project uppercase">Sortiment</a>
            </div>

            <a href="#firstSection" class="down-arrow">
                <span></span>
                <span></span>
                <span></span>
            </a>
        </div>

        <div class="w-screen relative flex my-40 px-60" id="firstSection">
            <div class="pr-8 w-1/2 flex justify-center items-center">
                <img class="w-100" src="/images/image1.png" alt="">
            </div>
            <div class="pl-8 w-1/2 flex justify-center items-center">
                <div class="w-100">
                    <h1 class="tracking-tight text-2xl text-project">Snabb leverans under timmen!</h1>
                    <p>Vi på Boardit jobbar konstant med att optimera upplevelsen för våra kunder. Det medför att vi kan ha en snabb leveranstid för alla öppettimmar där vi kan framföra en leverans på under en timme efter bekräftad beställlning.</p>
                </div>
            </div>
        </div>

        <div class="w-screen relative my-40">
            <h1 class="tracking-tight text-center text-2xl text-project">Populärt</h1>
            
            <div class="" v-if="!products.length">
                Loading...
            </div>
            <div v-else>
                <!-- :autoplay="true"  -->
                <VueSlickCarousel
                    v-if="products && products.length > 1"
                    :slidesToShow="5" 
                    :slidesToScroll="1"
                    :infinite="true" 
                    
                    :autoplaySpeed="3000" 
                    :arrows="false" 
                    :dots="true"
                >
                    <div v-for="product in products" :key="product.id" class="px-1 bg-opacity-10 shadow-sm rounded">
                        <router-link class="relative group" :to="{name: 'products.show', params: {slug: product.slug}}">
                            <div class="group-hover:opacity-100 opacity-0 text-white whitespace-nowrap absolute top-20 left-20 z-10 bg-project p-4 px-6 uppercase font-semibold">Visa spel</div>
                            <img class="w-100 h-48 bg-gray-200" src="#" :alt="product.name">
                        </router-link>
                        <div class="w-100 p-2 h-12 px-4 font-semibold justify-between flex items-center bg-gray-100">
                            <p class="text-sm" v-text="product.name"></p>
                            <p style="text-sm" v-text="formatCurrency(product.price)"></p>
                        </div>
                    </div>
                </VueSlickCarousel>
            </div>
        </div>

        <div class="w-screen relative flex my-40 px-60">
            <div class="w-50 flex justify-center items-center">
                <div class="w-100 text-left p-0">
                    <h1 class="tracking-tight text-2xl text-project">Vet du inte vad du ska välja för spel?</h1>
                    <p>Är du osäker på vilket spel du vill spela, eller vill du testa något nytt för att utforska nya spel? Varför inte beställa ett hemligt spel och låta ödet avgöra.</p>
                    <a href="#" class="inline-block no-underline font-semibold mt-4 px-4 py-4 text-white bg-project">Beställ hemligt spel</a>
                </div>
            </div>
            <div class="w-50 flex justify-center items-center">
                <img class="w-100" src="/images/image2.png" alt="">
            </div>
        </div>

        <div class="w-screen relative flex my-40 p-16 flex-col">
            <h1 class="tracking-tight text-2xl text-center text-project">Nyheter</h1>
            <div class="flex">
                <div class="w-2/3" style="height:40rem;">
                    <div class="w-full h-full p-10">
                        <img class="h-4/5 w-full bg-gray-200" src="#" alt="">
                        <div class="h-1/5 w-full bg-gray-300 text-white flex justify-center items-center">
                            <p class="">name - price</p>
                        </div>
                    </div>
                </div>
                <div class="w-1/3" style="height:40rem;">
                    <div class="h-1/2 w-full flex">
                        <div class="w-full h-full pt-10 pl-5 pb-5">
                            <img class="h-4/5 w-full bg-gray-200" src="#" alt="">
                            <div class="h-1/5 w-full bg-gray-300 text-white flex justify-center items-center">
                                <p class="">name - price</p>
                            </div>
                        </div>
                    </div>
                    <div class="h-1/2 w-100 flex">
                        <div class="w-full h-full pb-10 pl-5 pt-5">
                            <img class="h-4/5 w-full bg-gray-200" src="#" alt="">
                            <div class="h-1/5 w-full bg-gray-300 text-white flex justify-center items-center">
                                <p class="">name - price</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-screen relative my-40" style="height: 30rem;">
            <div class="" id="map"></div>
            <GmapMap
              :center="{ lat: 59.3774758, lng: 13.5137081 }"
              :zoom="13"
              :draggable="false"
              :options="{
                zoomControl: false,
                mapTypeControl: false,
                scaleControl: false,
                streetViewControl: false,
                rotateControl: false,
                fullscreenControl: false,
                disableDefaultUi: true
             }"
              class="w-full h-full"
            >
              <GmapMarker
                :position="{ lat: 59.3774758, lng: 13.5137081 }"
              />
            </GmapMap>
            
            <div class="flex justify-center absolute left-44 top-32 py-6 px-10 bg-white flex-col">
                <h3 class="tracking-tight text-2xl text-project">Vårt lager</h3>
                <p>
                    Fryxellsgatan 8<br>
                    Karlstad, Sverige
                </p>
                <p class="mt-4">
                    Mån - Fre, 10.00 - 21.00<br>
                    Lördag, 11.00 - 22.00<br>
                    Söndag, 11.00 - 17.00
                </p>
            </div>
        </div>

        <div class="w-screen relative flex-col mt-40 p-16 flex justify-center items-center">
            <div class="w-1/2">
                <h1 class="text-center tracking-tight text-4xl text-project">Kolla in vårat sortiment!</h1>
                <p class="text-center">Välj över 20 olika typer av brädspel för att hitta det perfekta spelet för det bästa tillfället. Vi har spel för sällskap mellan 2 spelare upp till 10 spelare.</p>
            </div>

            
            <router-link :to="{name: 'products'}" class="shadow-md rounded-md my-20 uppercase inline-block no-decoration font-semibold bg-project mt-4 py-4 px-8 text-white">Till sortimentet</router-link>
            
            <hr class="w-16 border-project" />
        </div>
    </div>
</template>

<script>
import VueSlickCarousel from 'vue-slick-carousel'
import 'vue-slick-carousel/dist/vue-slick-carousel.css'
import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'
  
export default {
    computed: {
        products() {
            return this.$store.state.products;
        }
    },
    methods: {
        formatCurrency(price) {
            price = (price / 100);
            return price.toLocaleString('sv-SE', { style: 'currency', currency: 'SEK' });
        }
    },
    components: { VueSlickCarousel }
}
</script>