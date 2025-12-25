<template>
    <DataTable v-bind="props"></DataTable>
</template>

<script setup lang="ts">
import DataTable from '@/custom-components/data-table/data-table.vue';
import { ProductListInterface } from './index';

const props = defineProps<ProductListInterface>();
</script>

<style scoped lang="scss"></style>
