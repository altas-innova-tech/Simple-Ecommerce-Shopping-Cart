<template>
    <div class="flex flex-col gap-2">
        <FieldTextarea
            detail="Go to GoogleMaps -> Share -> Embed a map (tab)"
            v-bind="props"
            :on_change="handleUpdate"
            :rows="6"
        ></FieldTextarea>

        <div v-html="iframeUrl"/>
    </div>
</template>

<script setup lang="ts">
import FieldTextarea from "../field-textarea.vue";
import {CommonFieldsPropertiesInterface} from "../index";
import {ref, watch} from 'vue';

export interface GoogleMapsFieldInterface extends CommonFieldsPropertiesInterface {
    cols?: number;
    rows?: number;
}

const props = withDefaults(defineProps<GoogleMapsFieldInterface>(), {});

const iframeUrl = ref<string>(props.value);

const handleUpdate = (value: string) => {
    iframeUrl.value = value;
};

// Watch for initial value or external changes
watch(() => props.value, (newValue) => {
    if (newValue) {
        iframeUrl.value = newValue as string;
    }
}, {immediate: true});
</script>

<style scoped lang="scss">
:deep(iframe) {
    border-radius: 8px;
    width: 100%;
    max-width: 100%;
    height: 450px;
}
</style>
