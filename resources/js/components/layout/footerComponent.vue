<template>
    <div class="w-full h-20 flex justify-between py-20 px-60">
        <div class="flex justify-center items-center ml-2.5">
            <ul class="list-none">
                <!-- <li><a href="#" class="">Om oss</a></li> -->
                <li class="mb-3 font-medium"><router-link :to="{name:'general.terms'}">Terms And Conditions</router-link></li>
                <li class="font-medium"><router-link :to="{name:'products'}">Produkter</router-link></li>
            </ul>
        </div>
        <div class="flex text-right flex-col justify-center">
            <p>© {{ moment().format("YYYY") }}, Boardit</p>
            <p>Betalsätt</p>
        </div>
    </div>
</template>

<script>
    import moment from "moment";

    export default {
        mounted() {},
        data() {
            return {
                moment: moment
            }
        }
    }
</script>
