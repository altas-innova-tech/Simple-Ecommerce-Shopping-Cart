<template>
    <Button
        :variant="type ?? 'default'"
        class="w-fit flex justify-start font-normal"
        type="button"
    >
        <Icon v-if="icon" class="w-4 h-4" :name="icon"/>
        <span v-if="label">{{ label }}</span>
        <Icon v-if="icon_right" class="w-4 h-4" :name="icon_right"/>
    </Button>
</template>

<script setup lang="ts">
import {Button} from '@/components/ui/button'
import {ButtonsInterface} from "../index";
import Icon from "../../icon.vue";

const props = withDefaults(defineProps<ButtonsInterface>(), {})
</script>
