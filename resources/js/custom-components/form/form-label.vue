<template>
    <span v-if="label" class="form-label">{{ label }}</span>
</template>

<script lang="ts" setup>
interface FormLabelInterface {
    label?: string
}

const props = defineProps<FormLabelInterface>()
</script>

<style scoped lang="scss">
.form-label {
    @apply text-gray-400;

    &:first-letter {
        @apply uppercase;
    }
}
</style>
