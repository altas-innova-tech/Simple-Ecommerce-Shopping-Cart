<template>
    <div :class="`flex flex-${direction} justify-start gap-1`">
        <template
            v-for="action in actions"
        >
            <ButtonConfirme
                v-if="action.button_confirme"
                v-bind="action"
            ></ButtonConfirme>

            <CustomButton
                v-else
                :type="action.type"
                :icon="action.icon"
                @click="handle_clicked(action)"
                :label="action.label"
                :method="action.method"
                :url="action.url"
                :color="action.color"
            ></CustomButton>
        </template>
    </div>
</template>

<script lang="ts" setup>
//=========================================================================================================
// Fonction pour charger le composant en fonction du render
//=========================================================================================================
import {ActionsInterface} from "../data-table";
import {router} from "@inertiajs/vue3";
import CustomButton from "../render-buttons/buttons/custom-button.vue";
import ButtonConfirme from "../modals/button-confirme.vue";
import {inject, Ref, ref} from "vue"

interface RenderActionsInterface {
    actions: ActionsInterface[];
    direction?: 'row' | 'col';
    formulaire?: HTMLFormElement | null;
}

const props = withDefaults(defineProps<RenderActionsInterface>(), {
    direction: 'row',
    formulaire: () => inject<Ref<HTMLFormElement | null>>('formulaire', ref(null)),
})


const handle_clicked = (action: ActionsInterface) => {
    let values = null;
    if (props.formulaire && props.formulaire.value) {
        const form_data = new FormData(props.formulaire.value);
        const form_entries = Array.from(form_data.entries());
        values = Object.fromEntries(form_entries);
    }

    console.log(action.method, action.method === "POST" && action.permission === 'store');
    switch (action.method) {
        case "GET":
            router.visit(action.url, {
                method: action.method?.toString()?.toLowerCase(),
                preserveState: true,
            });
            break;
        case "POST":
            if (action.permission !== 'store') {
                router.visit(action.url, {
                    method: action.method?.toString()?.toLowerCase(),
                    preserveState: true,
                });
            } else {
                router.visit(action.url, {
                    method: action.method?.toString()?.toLowerCase(),
                    data: values ?? [],
                    preserveState: true,
                });
            }
            break;
        case "PUT":
            if (action.permission === 'update') {
                router.visit(action.url, {
                    method: action.method?.toString()?.toLowerCase(),
                    data: values ?? [],
                    preserveState: true,
                });
            }
            break;
        default:
            console.error(`Unknown Method : ${action.method} (handle_clicked)`);
    }
}
</script>

<style scoped lang="scss">

</style>
