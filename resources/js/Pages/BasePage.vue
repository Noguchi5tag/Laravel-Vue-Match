<script setup>
    import HeaderComponent from '../Layouts/HeaderLayout.vue';
    import FooterComponent from '../Layouts/FooterLayout.vue';
</script>

<template>
    <div class="bg-green-100">
        <div class="max-w-sm m-auto bg-white">
            <HeaderComponent/>

                <slot />
            
            <FooterComponent />
        </div>
    </div>
</template>
