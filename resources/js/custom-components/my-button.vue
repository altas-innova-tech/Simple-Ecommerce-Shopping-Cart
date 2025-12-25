<template>
    <button
        :class="[$attrs.class, 'my-button', `bg-${color}-600 focus:ring-${color}-500 hover:bg-${color}-700`]"
        :type="type"
        @click="handle_click"
    >
        <Icon
            v-if="icon"
            :icon="icon"
            class="lg:h-4 h-3 lg:w-4 w-3"
            color="white"
        />
        <span v-if="label">{{ label }}</span>
    </button>
</template>

<script lang="ts" setup>
import Icon from "./icon.vue";

export interface MyButtonInterface {
    label?: string;
    icon?: string;
    color?: string;
    icon_only?: string;
    on_click?: () => void;
    type?: "button" | "submit";
}

const props = withDefaults(defineProps<MyButtonInterface>(), {
    type: "button"
})


const handle_click = () => {
    if (props.on_click) {
        props.on_click()
    }
}
</script>

<style scoped lang="scss">
.my-button {
    @apply inline-flex items-center justify-center gap-1 px-1.5 py-1 border border-transparent shadow-sm text-xs lg:text-sm leading-4 font-medium rounded-md text-white;

    &:focus {
        @apply outline-none;
    }
}
</style>
