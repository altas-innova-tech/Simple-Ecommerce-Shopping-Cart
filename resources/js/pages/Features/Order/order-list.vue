<template>
    <DataTable v-bind="props"></DataTable>
</template>

<script setup lang="ts">
import DataTable from '@/custom-components/data-table/data-table.vue';
import {  OrderListInterface } from './index';

const props = defineProps<OrderListInterface>();
</script>

<style scoped lang="scss"></style>
