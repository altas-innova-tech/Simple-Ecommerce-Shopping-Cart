<template>
    <MyForm :actions="actions" :model="model">
        <FieldText
            label="Name"
            :value="model?.name"
            :mode="permission"
            name="name"
        ></FieldText>

        <FieldNumber
            label="Price"
            :value="model?.price"
            :mode="permission"
            name="price"
        ></FieldNumber>

        <FieldNumber
            label="Stock quantity"
            :value="model?.stock_quantity"
            :mode="permission"
            name="stock_quantity"
        ></FieldNumber>
    </MyForm>
</template>

<script setup lang="ts">
import { ProductViewInterface } from './index';

import FieldNumber from '@/custom-components/fields/field-number.vue';
import FieldText from '@/custom-components/fields/field-text.vue';
import MyForm from '@/custom-components/form/my-form.vue';

defineProps<ProductViewInterface>();
</script>

<style scoped lang="scss"></style>
