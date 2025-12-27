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
                <AlertDialogTitle v-html="button_confirme_label" />

                <FieldText
                    label="Product name"
                    :value="model?.name"
                    mode="view"
                ></FieldText>

                <FieldNumber
                    label="Product price"
                    :value="model?.price"
                    mode="view"
                ></FieldNumber>

                <FieldNumber
                    label="Quantity"
                    :value="quantity"
                    :max="model?.stock_quantity"
                    :min="1"
                    mode="edit"
                    :on_change="(new_value) => (quantity = new_value)"
                ></FieldNumber>
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
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from '@/components/ui/alert-dialog';
import FieldNumber from '@/custom-components/fields/field-number.vue';
import FieldText from '@/custom-components/fields/field-text.vue';
import { ProductInterface } from '@/pages/Features/Product';
import { router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { DataTableHelpers } from '../data-table/data-table-helpers';
import { ButtonsInterface } from '../render-buttons';
import CustomButton from '../render-buttons/buttons/custom-button.vue';

interface ButtonConfirmeInterface extends ButtonsInterface {}

const props = defineProps<ButtonConfirmeInterface>();
const { selected_items } = DataTableHelpers();
const model = computed<ProductInterface>(() => props.model as ProductInterface);
const quantity = ref<number>(model.value?.stock_quantity);

const handle_confirme = () => {
    router.visit(props.url, {
        method: props.method,
        data: {
            product_id: model.value?.id,
            quantity: quantity.value,
            price: model.value?.price,
        },
    });

    selected_items.value = [];
};
</script>
