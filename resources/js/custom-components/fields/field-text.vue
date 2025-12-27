<template>
    <Fields
        :disabled="disabled"
        :label="label"
        :mode="mode"
        :name="name"
        :detail="detail"
    >
        <div v-if="mode === 'list' || mode === 'list_deleted'">
            <slot name="mode-list"></slot>
            <span>{{ value }}</span>
        </div>

        <div v-else class="relative">
            <Input
                :id="name"
                :name="name"
                :placeholder="placeholder"
                :type="type"
                :model-value="value"
                :min="min"
                :max="max"
                :step="step"
                class="text-field"
                @input="handle_changed"
            />

            <slot name="mode-view"></slot>
        </div>
    </Fields>
</template>

<script lang="ts" setup>
import { CommonFieldsPropertiesInterface } from '@/custom-components/fields/index';
import { Input } from '@/components/ui/input';
import Fields from "@/custom-components/fields/fields.vue";

export interface TextFieldInterface extends CommonFieldsPropertiesInterface {
    min?: number;
    max?: number;
    step?: number;
}

const props = withDefaults(defineProps<TextFieldInterface>(), {
    type: 'text',
});

const handle_changed = (event: InputEvent) => {
    if (props.on_change) {
        props.on_change((event.target as HTMLInputElement)?.value);
    }
};
</script>

<style></style>
