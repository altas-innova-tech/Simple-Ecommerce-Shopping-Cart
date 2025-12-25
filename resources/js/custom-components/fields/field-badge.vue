<template>
    <Fields
        :disabled="disabled"
        :label="label"
        :mode="mode"
        :name="name"
    >
        <div v-if="Array.isArray(value)" class="inline-flex gap-1">
            <div
                v-for="item in value"
                :class="['badge', `bg-${item?.color} text-white`]"
            >
                <Icon class="w-3 h-3" v-if="item?.icon" :color="item?.color" :name="item?.icon"></Icon>
                <span v-if="item?.label"> {{ item?.label }}</span>
            </div>
        </div>


        <div v-else class="inline-flex gap-1">
            <div
                :class="['badge', `bg-${color_from_value} text-white`]"
            >
                <Icon class="w-3 h-3" v-if="icon_from_value" :color="color_from_value" :name="icon_from_value"></Icon>
                <span v-if="content"> {{ content }}</span>
            </div>
        </div>
    </Fields>
</template>

<script lang="ts" setup>

import {CommonFieldsPropertiesInterface} from "./index";
import {computed} from "vue";
import Icon from "../icon.vue";
import Fields from "./fields.vue";

interface BadgeInterface extends CommonFieldsPropertiesInterface {
}

const props = withDefaults(defineProps<BadgeInterface>(), {
    color: "gray"
});

const color_from_value = computed<string>(() => {
    if (props.value?.color) {
        return props.value?.color;
    }

    return props.color
})

const content = computed<string>(() => {
    if (props.value?.label) {
        return props.value?.label;
    }

    if (props.label) {
        return props.label;
    }

    return props.value
})


const icon_from_value = computed<string>(() => {
    if (props.value?.icon) {
        return props.value?.icon;
    }

    return props.icon

})
</script>

<style scoped lang="scss">
.badge {
    @apply inline-flex gap-1 items-center text-xs justify-center px-2.5 py-0.5 rounded-md select-none;

    span {
        @apply uppercase;
    }
}
</style>
