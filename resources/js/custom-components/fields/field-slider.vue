<template>
    <Fields
        :label="label"
        :mode="mode"
        :name="name"
    >
        <Switch :model-value="is_checked_value" @update:model-value="handle_changed">
            <template #thumb>
                <Icon v-if="icon" :name="icon" class="size-4"/>
            </template>
        </Switch>

        <input
            :name="name"
            :value="is_checked_value ? 1 : 0"
            type="hidden"
        />
    </Fields>
</template>

<script lang="ts" setup>
import {CommonFieldsPropertiesInterface} from "./index";
import Fields from "./fields.vue";
import {ref} from "vue";
import {Switch} from '@/components/ui/switch'
import Icon from "../icon.vue";

export interface SliderFieldInterface extends CommonFieldsPropertiesInterface {
}


const props = withDefaults(defineProps<SliderFieldInterface>(), {})


const is_checked_value = ref<boolean>(Boolean(props.value))

const handle_changed = (new_value) => {
    is_checked_value.value = new_value

    if (props.on_change) {
        props.on_change(is_checked_value.value)
    }
}
</script>


<style scoped lang="scss">
</style>
