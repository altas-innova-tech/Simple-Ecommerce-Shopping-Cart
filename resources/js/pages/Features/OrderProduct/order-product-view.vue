<template>
    <MyForm :actions="actions" :model="model">
        <FieldNumber
            label="Price"
            :value="model?.price"
            mode="view"
            name="price"
        ></FieldNumber>

        <FieldNumber
            label="Quantity"
            :value="model?.quantity"
            :mode="permission"
            :max="product.stock_quantity"
            :min="1"
            name="quantity"
        ></FieldNumber>

        <input name="product_id" type="hidden" :value="product.id" />
    </MyForm>
</template>

<script setup lang="ts">
import { OrderProductViewInterface } from './index';

import FieldNumber from '@/custom-components/fields/field-number.vue';
import MyForm from '@/custom-components/form/my-form.vue';
import { ProductInterface } from '@/pages/Features/Product';
import { computed } from 'vue';

const props = defineProps<OrderProductViewInterface>();

const product = computed<ProductInterface>(() => props.model?.product);
</script>

<style scoped lang="scss"></style>
