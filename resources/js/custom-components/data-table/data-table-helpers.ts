import {ref} from "vue";

const selected_items = ref<string[]>([])

export const DataTableHelpers = () => {
    return {
        selected_items,
    }
}
