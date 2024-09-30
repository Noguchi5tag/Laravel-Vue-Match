<script setup>
import { Head} from '@inertiajs/vue3';
import BasePage from '../Layouts/BaseLayouts.vue';
import SiteTitle from '../Components/SiteTitle.vue';
import InputLabel from '../Components/InputLabel.vue';
import TextInput from '../Components/TextInput.vue';
import TextArea from '../Components/TextArea.vue';
import PrimaryButton from '../Components/PrimaryButton.vue';
</script>

<template>
    <Head title="お問い合わせ" />
    <BasePage>
        <SiteTitle>お問い合わせ</SiteTitle>
        <SectionInner class="my-4">
                <div class="flex flex-wrap">
                    <div class="p-2">
                        <InputLabel for="name" class="mb-2">お名前</InputLabel>
                        <TextInput type="text" id="name" name="name" />
                    </div>
                    <div class="p-2">
                        <InputLabel for="name" class="mb-2">メールアドレス</InputLabel>
                        <TextInput type="email" id="email" name="email" />
                    </div>
                    <div class="p-2 w-full">
                        <InputLabel for="name" class="mb-2">お問い合わせ内容</InputLabel>
                        <TextArea id="message" name="message"/>
                    </div>
                </div>
                <div class="p-2 flex justify-center w-full">
                    <PrimaryButton>送信</PrimaryButton>
                </div>
        </SectionInner>
    </BasePage>

</template>
