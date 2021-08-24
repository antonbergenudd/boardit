<template>
    <div class="absolute w-full h-24 navbar px-56 flex z-10 justify-between">
        <div class="logo flex-center">
            <div class="relative w-40">
                <router-link :to="{name: 'index'}">
                    <img class="h-auto" :src="navBarLogo" alt="Boardit logo">
                </router-link>
            </div>
            </a>
        </div>
        <div :style="{color: navBarColor}" class="h-full whitespace-nowrap flex links items-center justify-center text-lg">
            <router-link class="hidden md:inline-block flex-1 transition-all px-3 no-underline uppercase text-sm font-semibold tracking-wide hover:opacity-70" to="products">Sortiment</router-link>
            <i class="fa fa-shopping-cart relative md:inline-block hidden flex-1 transition-all px-3 cursor-pointer hover:opacity-70" @click="$store.commit('toggleSidebar', !$store.state.showSidebar)">
                <div v-show="cart.length > 0" class="absolute -top-0.5 right-1 rounded-full bg-project w-2.5 h-2.5"></div>
            </i>
        </div>
    </div>
</template>

<script>
    export default {
        computed: {
            // TODO: Make display absolute based on page
            navBarColor() {
                if (this.$route.path == "/")
                    return "white";

                return "black";
            },
            navBarLogo() {
                if (this.$route.path == "/")
                    return "/images/logos/logo_white.png";

                return "/images/logos/logo_black.png";
            },
            cart() {
                return this.$store.state.cart;
            },
        }
    }
</script>
