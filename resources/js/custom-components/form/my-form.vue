<template>
    <div class="w-full flex justify-start items-center h-full">
        <form
            ref="form"
            class="flex flex-col gap-3 bg-white w-1/2 h-full rounded-lg border border-base py-2 px-3"
            @submit.prevent="handle_submit"
        >
            <slot name="default"/>

            <div class="flex justify-start mt-5">
                <RenderActions
                    :actions="actions"
                ></RenderActions>
            </div>

            <input name="key" :value="model?.key" type="hidden"/>
        </form>
    </div>
</template>

<script setup lang="ts">
import {ActionsInterface} from "../data-table";
import RenderActions from "../render-actions/render-actions.vue";
import {provide, ref} from "vue";

interface FormInterface {
    actions: ActionsInterface[];
    model: any;
}

const props = defineProps<FormInterface>()

const form = ref<HTMLFormElement | null>(null)

const handle_submit = (event: Event) => {
    event.preventDefault();
    // Your custom logic here
}

provide("formulaire", form);
</script>

<style scoped lang="scss">

</style>
