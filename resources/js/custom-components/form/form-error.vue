<template>
    <span v-if="error_msg" class="text-sm text-red-500 first-letter:uppercase">{{ error_msg }}</span>
</template>

<script lang="ts" setup>
import {computed} from "vue";
import {usePage} from "@inertiajs/vue3";

interface FormErrorInterface {
    name?: string
}

const props = defineProps<FormErrorInterface>()

const errors = computed(() => usePage().props?.errors)

const error_msg = computed<string>(() => errors.value?.[props.name])
</script>
