<template>
    <component :is="loader_component" v-bind="$props" />
</template>

<script lang="ts" setup>
//=========================================================================================================
// Fonction pour charger le composant en fonction du render
//=========================================================================================================
import fieldConstants from '@/constants/component-constants';
import { CommonFieldsPropertiesInterface } from '@/custom-components/fields/index';
import { computed, defineAsyncComponent } from 'vue';

const props = withDefaults(defineProps<CommonFieldsPropertiesInterface>(), {});

// eslint-disable-next-line vue/return-in-computed-property
const loader_component = computed(() => {
    switch (props.component) {
        case fieldConstants.component_text:
            return defineAsyncComponent(
                () => import('@/custom-components/fields/field-text.vue'),
            );
        case fieldConstants.component_textarea:
            return defineAsyncComponent(
                () => import('@/custom-components/fields/field-textarea.vue'),
            );
        case fieldConstants.component_number:
            return defineAsyncComponent(
                () => import('@/custom-components/fields/field-number.vue'),
            );
        case fieldConstants.component_badge:
            return defineAsyncComponent(
                () => import('@/custom-components/fields/field-badge.vue'),
            );
        case fieldConstants.component_color:
            return defineAsyncComponent(
                () => import('@/custom-components/fields/field-color.vue'),
            );
        case fieldConstants.component_email:
            return defineAsyncComponent(
                () => import('@/custom-components/fields/field-email.vue'),
            );
        case fieldConstants.component_phone:
            return defineAsyncComponent(
                () => import('@/custom-components/fields/field-phone.vue'),
            );
        case fieldConstants.component_date_time_picker:
            return defineAsyncComponent(
                () =>
                    import('@/custom-components/fields/Date/field-date-time-picker.vue'),
            );
        case fieldConstants.component_date:
            return defineAsyncComponent(
                () => import('@/custom-components/fields/Date/field-date.vue'),
            );
        case fieldConstants.component_slider:
            return defineAsyncComponent(
                () => import('@/custom-components/fields/field-slider.vue'),
            );
        case fieldConstants.component_phones:
            return defineAsyncComponent(
                () => import('@/custom-components/fields/field-phones.vue'),
            );
        default:
            console.error(`Unknown  : ${props.component}`);
    }
});
</script>

<style scoped lang="scss"></style>
