<template>
    <Link :href="href" class="ml-auto inline-block text-sm underline">
        <span v-if="label">{{label}}</span>
        <slot v-else />
    </Link>
</template>

<script lang="ts" setup>
import {Link} from '@inertiajs/vue3';

interface LinkInertiaInterface {
    href: string;
    label?:string;
}

const props = defineProps<LinkInertiaInterface>()
</script>

<style scoped lang="scss">

</style>
