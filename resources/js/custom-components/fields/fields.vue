<template>
    <div :class="['fields', {'disabled': mode === 'view' || disabled }]">
        <div class="flex flex-col gap-2">
            <Label v-if="display_label" class="font-normal mb-1" :for="name">{{ label }}</Label>
            <Label v-if="props.detail" class="mt-[0.5px] text-xs font-normal" :for="name">{{ detail }}</Label>
        </div>
        <slot name="default"></slot>
        <FormError class="mt-1" :name="name_error ?? name"></FormError>
    </div>
</template>

<script lang="ts" setup>
import FormError from "@/custom-components/form/form-error.vue";
import {CommonFieldsPropertiesInterface} from "@/custom-components/fields/index";
import {Label} from "@/components/ui/label";
import {computed} from "vue";


const props = defineProps<CommonFieldsPropertiesInterface>()

const display_label = computed<boolean>(() => props.label && !['list', 'list_deleted'].includes(props.mode!))
</script>

<style scoped lang="scss">
.fields {
    @reference flex flex-col gap-1;
}
</style>
