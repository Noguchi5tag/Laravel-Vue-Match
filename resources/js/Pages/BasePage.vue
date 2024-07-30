<template>
    <div class="bg-green-100">
        <div class="max-w-sm m-auto bg-white">
            <HeaderComponent/>

                <router-view></router-view>
            
            <FooterComponent />
        </div>
    </div>
</template>


<script setup>
    import HeaderComponent from '../Layouts/HeaderLayout.vue';
    import FooterComponent from '../Layouts/FooterLayout.vue';


</script>