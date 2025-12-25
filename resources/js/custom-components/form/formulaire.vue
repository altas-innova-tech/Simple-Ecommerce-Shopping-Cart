<template>
    <form
        ref="form"
        :class="[
            classes_form,
            'gap-2 bg-white p-4 rounded-md select-none',
            is_arrivage_product ? 'flex flex-col w-full' :'max-w-2xl grid grid-cols-1',
        ]"
        @submit.prevent="handle_form_submit"
    >
        <div v-if="display_top_actions" :class="['flex gap-2 justify-end py-2', {'disabled' : on_submitting }]">
            <MyButton
                v-for="action in actions"
                :color="action.color"
                :icon="action.icon"
                :label="action.label"
                :type="action.type"
                @click="() => {
                    selected_action = action
                    handle_click(action)
                }"
            ></MyButton>
        </div>


        <slot name="headers"></slot>
        <div
            :class="[{'disabled' : on_submitting || mode === 'view' }, 'flex flex-col gap-4 overflow-y-auto', classes_inputs]">
            <slot :form="form" name="default"></slot>
        </div>

        <div :class="['flex gap-2 justify-end py-2', {'disabled' : on_submitting }]">
            <slot v-if="$slots.actions" :form="form" name="actions"></slot>

            <MyButton
                v-for="action in actions"
                v-else
                :color="action.color"
                :icon="action.icon"
                :label="action.label"
                :type="action.type"
                @click="() => {
                    selected_action = action
                    handle_click(action)
                }"
            ></MyButton>
        </div>
    </form>
</template>

<script lang="ts" setup>
import {router, usePage} from '@inertiajs/vue3'
import {route} from 'ziggy-js'
import {ref, watch} from "vue";
import MyButton from "../my-button.vue";
import {ActionInterface} from "../../Features";

export interface FormulaireInterface {
    mode?: string;
    actions?: ActionInterface[];
    item?: { key?: string };
    display_top_actions?: boolean;
    classes_inputs?: string;
    is_arrivage_product?: boolean;
    submit_url?: string;
    is_submited?: () => void;
    classes_form?: string;
}

const props = withDefaults(defineProps<FormulaireInterface>(), {
    display_top_actions: false
})

const form = ref<HTMLFormElement | null>(null)
const on_submitting = ref<boolean>(false)
const feature = ref<string>(usePage().props?.feature as any)

const selected_action = ref<ActionInterface | null>(null)

const handle_form_submit = () => {
    if (props.submit_url) {
        router.post(props.submit_url, form.value, {
            onStart: () => on_submitting.value = true,
            onFinish: () => on_submitting.value = false,
        })

        return;
    }

    const params = {
        key: props?.item?.key
    }


    router.post(route(`${feature.value}.${selected_action.value.mode}`, params), form.value, {
        onStart: () => on_submitting.value = true,
        onFinish: () => on_submitting.value = false,
    })
}


const handle_click = (action: ActionInterface) => {
    if (action.type !== "submit") {
        let mode = "list";
        let params = {};

        if (action.mode === "edit") {
            mode = "edit"
            params = {
                key: props.item.key
            }
        }

        const name = `${feature.value}.${mode}`

        router.get(action.url ?? route(name, params))
    }
}

watch([on_submitting], () => {
    if (props.is_submited) {
        if (!on_submitting.value) {
            props.is_submited()
        }
    }
})
</script>


<style scoped lang="scss">
</style>
