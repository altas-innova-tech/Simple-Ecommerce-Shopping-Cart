<template>
    <component
        :is="icon"
        :size="size"
        :stroke-width="stroke_width"
        :default-class="[`text-${color}-500`, classes]"
    />
</template>

<script setup lang="ts">
import {computed, defineAsyncComponent} from 'vue';

interface IconInterface {
    name: string,
    size?: number,
    color?: string;
    stroke_width?: number,
    classes?: string
}

const props = withDefaults(defineProps<IconInterface>(), {
    color: "white",
    stroke_width: 2,
})

const icon = computed(() => defineAsyncComponent(async () => {
    const mod = await import(/* @vite-ignore */ 'lucide-vue-next')
    return (mod as any)[props.name]
}));
</script>
