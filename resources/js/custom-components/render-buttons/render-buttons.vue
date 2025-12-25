<template>
    <Button
        v-for="action in actions"
        :variant="action.type ?? 'primary'"
        @click="handle_clicked(action)"
    >
        {{ action.label }}
    </Button>
</template>

<script lang="ts" setup>
//=========================================================================================================
// Fonction pour charger le composant en fonction du render
//=========================================================================================================
import {computed, defineAsyncComponent} from "vue";
import fieldConstants from "@/constants/component-constants";
import {ActionsInterface} from "../data-table";
import {Button} from "@/components/ui/button";
import {router} from "@inertiajs/vue3";

interface RenderActionsInterface {
    actions: ActionsInterface[];
}

const props = withDefaults(defineProps<RenderActionsInterface>(), {})


const loader_component = computed(() => {
    switch (props.component) {
        case fieldConstants.component_text:
            return defineAsyncComponent(() => import("../components/fields/field-text.vue"));
        default :
            console.error(`Unknown  : ${props.component}`)
    }
})


const handle_clicked = (action: ActionsInterface) => {
    switch (action.method) {
        case "GET":
            router.visit(action.url);
            break;
        default:
            console.error(`Unknown Method : ${action.method} (handle_clicked)`)

    }
}
</script>

<style scoped lang="scss">

</style>
