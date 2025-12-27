<template>
    <MyForm :actions="actions" :model="model">
        <FieldText
            label="User"
            :value="model?.user.name"
            mode="view"
        ></FieldText>

        <FieldSelect
            label="Status"
            :value="model?.status"
            :mode="permission"
            name="status"
            :values="status"
        ></FieldSelect>

        <input name="user_id" :value="model?.user_id" type="hidden"  />
    </MyForm>
</template>

<script setup lang="ts">
import { OrderViewInterface } from './index';

import FieldText from '@/custom-components/fields/field-text.vue';
import FieldSelect from '@/custom-components/fields/select/field-select.vue';
import MyForm from '@/custom-components/form/my-form.vue';

defineProps<OrderViewInterface>();
</script>

<style scoped lang="scss"></style>
