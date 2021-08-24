<template>
    <div>
        <div :class="{sidebarVisible: this.$store.state.showSidebar}">
            <navbar-component v-show="!checkoutView"></navbar-component>
        
            <router-view></router-view>
        
            <footer-component v-show="!checkoutView"></footer-component>
        </div>
        
        <sidebar-component></sidebar-component>
        
        <chat-support-component></chat-support-component>
    </div>
</template>

<script>
    export default {
        computed: {
            checkoutView() {
                if (this.$route.path.includes('checkout'))
                    return true;

                return false;
            }
        }
    }
</script>
