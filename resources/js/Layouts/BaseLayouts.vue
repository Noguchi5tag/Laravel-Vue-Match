<script setup>
    import HeaderComponent from '../Layouts/HeaderLayout.vue';
    import FooterComponent from '../Layouts/FooterLayout.vue';
</script>

<template>
    <div class="">
        <div class="max-w-sm m-auto">
            <HeaderComponent/>

                <slot />
            
            <FooterComponent />
        </div>
    </div>
</template>
