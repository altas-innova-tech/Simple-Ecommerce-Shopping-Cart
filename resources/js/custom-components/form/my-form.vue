<template>
    <div class="flex h-full w-full items-start justify-start">
        <form
            ref="form"
            class="border-base flex w-1/2 flex-col gap-3 rounded-lg border dark:bg-neutral-900 px-3 py-2"
            @submit.prevent="handle_submit"
        >
            <slot name="default" />

            <div class="mt-5 flex justify-start">
                <RenderActions :actions="actions"></RenderActions>
            </div>

            <input name="key" :value="model?.key" type="hidden" />
        </form>
    </div>
</template>

<script setup lang="ts">
import { ActionsInterface } from '../data-table';
import RenderActions from '../render-actions/render-actions.vue';
import { provide, ref } from 'vue';

interface FormInterface {
    actions: ActionsInterface[];
    model: any;
}

const props = defineProps<FormInterface>();

const form = ref<HTMLFormElement | null>(null);

const handle_submit = (event: Event) => {
    event.preventDefault();
    // Your custom logic here
};

provide('formulaire', form);
</script>

<style scoped lang="scss"></style>
