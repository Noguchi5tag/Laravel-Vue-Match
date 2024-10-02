<script setup>
import BaseLayouts from '../Layouts/BaseLayouts.vue';
import SiteTitle from '../Components/SiteTitle.vue';
import LoginForm from './Auth/Login.vue';

</script>

<template>
    <BaseLayouts>

        <SiteTitle>会員登録</SiteTitle>

        <LoginForm />
        
    </BaseLayouts>
</template>