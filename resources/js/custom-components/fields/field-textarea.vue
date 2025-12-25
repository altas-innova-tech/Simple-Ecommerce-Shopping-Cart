<template>
    <Fields
        :label="label"
        :mode="mode"
        :name="name"
        :detail="detail"
        class="w-full"
    >
        <div v-if="mode === 'list' || mode === 'list_deleted'">
            <span>{{ value }}</span>
        </div>

        <div v-else class="relative">
            <Textarea
                :id="name"
                :cols="cols"
                :name="name"
                :placeholder="placeholder"
                :rows="rows"
                v-model="localValue"
                class="text-field"
            />
            <slot name="mode-view"></slot>
        </div>
    </Fields>
</template>

<script lang="ts" setup>
import {ref, watch} from 'vue';
import {CommonFieldsPropertiesInterface} from "./index";
import Fields from "./fields.vue";
import {Textarea} from "@/components/ui/textarea";

export interface TextAreaFieldInterface extends CommonFieldsPropertiesInterface {
    cols?: number;
    rows?: number;
}

const props = withDefaults(defineProps<TextAreaFieldInterface>(), {});

// Create a local reactive value
const localValue = ref(props.value || '');

// Watch for external changes to the value prop
watch(() => props.value, (newValue) => {
    localValue.value = newValue || '';
});

// Watch for local changes and emit to parent
watch(localValue, (newValue) => {
    if (props.on_change) {
        props.on_change(newValue);
    }
});
</script>

<style>
</style>
