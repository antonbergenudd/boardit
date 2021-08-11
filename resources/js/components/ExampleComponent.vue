<template>
    <div>
        <div class="block hero flex-center" style="background:url('/images/playing-card-games-at-a-table.jpg') rgba(0, 0, 0, 0.3); background-position: center; background-repeat: no-repeat; background-size: cover; background-blend-mode: multiply;">
            <div class="" style="text-align:center;">
                <p style="font-weight:600;">Hyr brädspel hem till dörren</p>
                <h1 style="font-size:40pt;">Upptäck dina favoriter</h1>
                <a href="#" class="button" style="display: inline-block; text-decoration: none; font-weight: bold; margin-top: 1rem; padding:1rem 2rem; background-color: #96ddff; color:white;">Sortiment</a>
            </div>

            <a href="#firstSection" class="down-arrow">
                <span></span>
                <span></span>
                <span></span>
            </a>
        </div>

        <div class="block v-split" id="firstSection" style="margin:0 10rem; width:calc(100% - 20rem);">
            <div class="block-section flex-center">
                <img src="/images/image1.png" alt="" style="width:100%;">
            </div>
            <div class="block-section flex-center">
                <div class="text-wrapper" style="text-align:left; padding:0;">
                    <h3>Snabb leverans under timmen!</h3>
                    <p>Vi på Boardit jobbar konstant med att optimera upplevelsen för våra kunder. Det medför att vi kan ha en snabb leveranstid för alla öppettimmar där vi kan framföra en leverans på under en timme efter bekräftad beställlning.</p>
                </div>
            </div>
        </div>

        <div class="block carousel flex-center" style="flex-direction: column;">
            <h1 style="text-align:center;">Populärt</h1>
            <div class="product-slide" style="width:100%;">
                <div v-for="product in products" style="margin:1rem; background-color:rgba(0,0,0,.1); box-shadow: -2px -2px 8px rgba(0,0,0,.2); border-radius: 5px;">
                    <img src="" alt="" style="width:100%; height:12rem; background-color:gray;">
                    <div class="flex-center" style="width:100%; height:4rem;  font-weight: 600; justify-content:space-between;">
                        <p style="padding-left:1rem;">{{ product.name }}</p>
                        <p style="padding-right:1rem;">{{ product.price }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="block v-split" style="margin:0 10rem; width:calc(100% - 20rem);">
            <div class="block-section flex-center">
                <div class="text-wrapper" style="text-align:left; padding:0;">
                    <h3>Vet du inte vad du ska välja för spel?</h3>
                    <p>Är du osäker på vilket spel du vill spela, eller vill du testa något nytt för att utforska nya spel? Varför inte beställa ett hemligt spel och låta ödet avgöra.</p>
                    <a href="#" class="button" style="display: inline-block; text-decoration: none; font-weight: bold; margin-top: 1rem; padding:1rem 2rem; background-color: #96ddff; color:white;">Beställ hemligt spel</a>
                </div>
            </div>
            <div class="block-section flex-center">
                <img src="/images/image2.png" alt="" style="width:100%;">
            </div>
        </div>

        <div class="block">
            <h1 style="text-align:center;">Nyheter</h1>
            <div class="grid" style="margin:0 15rem; display:flex;">
                <div class="grid_item-large" style="width:66.66%; height:40rem;">
                    <div class="" style="margin:2.5rem; width:calc(100% - 5rem); height: calc(100% - 5rem);">
                        <img src="" alt="" style="height:80%; width:100%; background-color:gray;">
                        <div class="flex-center" style="height:20%; width:100%;">
                            <p style="height:10%; margin:0;">name - price</p>
                        </div>
                    </div>
                </div>
                <div class="" style="width:33.33%; height:40rem;">
                    <div class="grid_item-small" style="height:50%; width: 100%; display:flex;">
                        <div class="" style="margin:2.5rem; margin-bottom:0; width:calc(100% - 5rem); height: calc(100% - 5rem);">
                            <img src="" alt="" style="height:80%; width:100%; background-color:gray;">
                            <div class="flex-center" style="height:20%; width:100%;">
                                <p style="height:10%; margin:0; width:auto;">name - price</p>
                            </div>
                        </div>
                    </div>
                    <div class="grid_item-small" style="height:50%; width: 100%; display:flex;">
                        <div class="" style="margin:2.5rem; margin-top:0;width:calc(100% - 5rem); height: calc(100% - 5rem);">
                            <img src="" alt="" style="height:80%; width:100%; background-color:gray;">
                            <div class="flex-center" style="height:20%; width:100%;">
                                <p style="height:10%; margin:0; width:auto;">name - price</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="block maps" style="height: 30rem; position:relative;">
            <div class="" id="map"></div>
            <div class="flex-center" style="position: absolute; left:20rem; top:5rem; width:17.5rem; height:20rem; background-color:white; flex-direction:column;">
                <h3 style="margin:0;">Vårt lager</h3>
                <p>Fryxellsgatan 8<br>Karlstad, Sverige</p>
                <p>Mån - Fre, 10.00 - 21.00<br>
                Lördag, 11.00 - 22.00<br>
                Söndag, 11.00 - 17.00</p>
            </div>
        </div>

        <!-- <style media="screen">
        /* Set the size of the div element that contains the map */
        #map {
        height: 100%;
        /* The height is 400 pixels */
        width: 100%;
        /* The width is the width of the web page */
        }
        </style>
        <script type="text/javascript">
        // Initialize and add the map
        function initMap() {
            // The location of Uluru
            const uluru = { lat: -25.344, lng: 131.036 };
            // The map, centered at Uluru
            const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 4,
            center: uluru,
            disableDefaultUI: true,
            });
            // The marker, positioned at Uluru
            const marker = new google.maps.Marker({
            position: uluru,
            map: map,
            });
        }
        </script> -->

        <div class="block flex-center" style="flex-direction:column; text-align:center;">
            <div class="text-wrapper" style="width:40rem;">
                <h1>Kolla in vårat sortiment!</h1>
                <p>Välj över 20 olika typer av brädspel för att hitta det perfekta spelet för det bästa tillfället. Vi har spel för sällskap mellan 2 spelare upp till 10 spelare.</p>
            </div>

            <a href="#" class="button" style="display: inline-block; text-decoration: none; font-weight: bold; margin-top: 1rem; padding:1rem 2rem; background-color: #96ddff; color:white;">Till sortimentet</a>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                products: [],
            };
        },
        mounted() {
            axios.get('/products').then(response => {
               this.products = response.data;
           });
       }
    }
</script>
