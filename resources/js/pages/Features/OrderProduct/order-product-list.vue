<template>
    <DataTable v-bind="props"></DataTable>
</template>

<script setup lang="ts">
import DataTable from '@/custom-components/data-table/data-table.vue';
import { OrderProductListInterface } from './index';

const props = defineProps<OrderProductListInterface>();
</script>

<style scoped lang="scss"></style>
