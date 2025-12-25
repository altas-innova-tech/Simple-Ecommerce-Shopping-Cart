<template>
    <MyForm :actions="actions" :model="model"> </MyForm>
</template>

<script setup lang="ts">
import { OrderViewInterface } from './index';

import MyForm from '@/custom-components/form/my-form.vue';

defineProps<OrderViewInterface>();
</script>

<style scoped lang="scss"></style>
