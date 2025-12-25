<template>
    <AlertDialog>
        <AlertDialogTrigger as-child>
            <CustomButton
                :type="type"
                :icon="icon"
                :label="label"
                :method="method"
                :url="url"
                :color="color"
            ></CustomButton>
        </AlertDialogTrigger>

        <AlertDialogContent>
            <AlertDialogHeader>
                <AlertDialogTitle v-html="button_confirme_label"/>
                <AlertDialogDescription v-html="button_confirme_description"/>
            </AlertDialogHeader>

            <AlertDialogFooter>
                <AlertDialogCancel>Cancel</AlertDialogCancel>

                <CustomButton
                    label="Confirme"
                    type="destructive"
                    class="w-fit"
                    @click="handle_confirme"
                ></CustomButton>
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>

<script setup lang="ts">
import {
    AlertDialog,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from '@/components/ui/alert-dialog'
import {ButtonsInterface} from "../render-buttons";
import CustomButton from "../render-buttons/buttons/custom-button.vue";
import {router} from "@inertiajs/vue3";
import {DataTableHelpers} from "../data-table/data-table-helpers";

interface ButtonConfirmeInterface extends ButtonsInterface {
}

const props = defineProps<ButtonConfirmeInterface>()
const {selected_items} = DataTableHelpers();

const handle_confirme = () => {
    router.visit(props.url, {
        method: props.method,
        data: {
            keys: selected_items.value
        },
    });

    selected_items.value = [];
}
</script>
