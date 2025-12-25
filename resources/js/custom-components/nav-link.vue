<template>
    <Link :href="href">
        <slot/>
    </Link>
</template>

<script lang="ts" setup>
import {Link} from '@inertiajs/vue3';

interface LinkInertiaInterface {
    href: string;
}

const props = defineProps<LinkInertiaInterface>()
</script>

<style scoped lang="scss">

</style>
