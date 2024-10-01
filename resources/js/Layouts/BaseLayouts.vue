<script setup>
    import HeaderComponent from '../Layouts/HeaderLayout.vue';
    import FooterComponent from '../Layouts/FooterLayout.vue';
</script>

<template>
    <!-- 後でborder消す -->
    <div class="max-w-sm m-auto border-x-2 border-black">
        <HeaderComponent/>

            <slot />
        
        <FooterComponent />
    </div>
</template>
