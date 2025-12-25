<template>
    <FieldText
        :mode="mode"
        :disabled="disabled"
        :id="name"
        :max="max"
        :min="min"
        :label="label"
        :name="name"
        :placeholder="placeholder"
        :step="step"
        :type="type"
        :value="value"
        class="text-field"
        @input="handle_changed"
    />
</template>

<script lang="ts" setup>
import {CommonFieldsPropertiesInterface} from "./index";
import FieldText from "./field-text.vue";

export interface NumberFieldInterface extends CommonFieldsPropertiesInterface {
    max?: number;
    min?: number;
    step?: number;
}


const props = withDefaults(defineProps<NumberFieldInterface>(), {
    type: "number"
})


const handle_changed = (event: InputEvent) => {
    if (props.on_change) {
        props.on_change((event.target as HTMLInputElement)?.value)
    }
}
</script>


<style>
</style>
