<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
});

const textarea = ref(null);

onMounted(() => {
    if (textarea.value.hasAttribute('autofocus')) {
        textarea.value.focus();
    }
});

defineExpose({ focus: () => textarea.value.focus() });
</script>

<template>
    <textarea
        class="w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
        v-model="model"
        rows="8"
        ref="textarea"
    />
</template>