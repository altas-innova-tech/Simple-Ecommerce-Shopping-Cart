<template>
    <div class="flex flex-wrap gap-2">
        <DataTableFilters
            v-for="filter_option in filter_options"
            :key="filter_option.name"
            :filter_option="filter_option"
            :model_value="get_filter_value(filter_option.name)"
            @update:model_value="(value) => handle_filter_change(filter_option.name, value)"
        />

        <CustomButton
            v-if="has_filtration"
            label="Reset"
            type="ghost"
            icon_right="X"
            class="w-fit h-8"
            @click="clear_all_filters"
        ></CustomButton>
    </div>
</template>

<script setup lang="ts">
import {computed} from 'vue'
import {DataTableFiltersInterface} from "./index";
import DataTableFilters from "./data-table-filters.vue";
import CustomButton from "../render-buttons/buttons/custom-button.vue";


const props = defineProps<DataTableFiltersInterface>()
const emit = defineEmits<{
    'update:model_value': [value: Record<string, (string | number)[]>]
}>()


const filters = computed(() => props.model_value || {})
const has_filtration = computed(() => props.filter_options?.some((option) => option?.value?.length))

const handle_filter_change = (filter_name: string, value: (string | number)[] | undefined) => {
    const new_filters = {...filters.value}

    // More explicit check for when to keep vs remove the filter
    if (value !== undefined && Array.isArray(value) && value.length > 0) {
        new_filters[filter_name] = value
    } else {
        // Remove the filter entirely when value is undefined, null, or empty array
        delete new_filters[filter_name]
    }

    emit('update:model_value', new_filters, filter_name)
}

const get_filter_value = (filterName: string): (string | number)[] => {
    if (filters.value[filterName]) {
        return filters.value[filterName]
    }

    const filter_option = props.filter_options.find(opt => opt.name === filterName)
    if (filter_option && filter_option.value) {
        if (typeof filter_option.value === 'string') {
            try {
                const parsed = JSON.parse(filter_option.value)
                return Array.isArray(parsed) ? parsed : []
            } catch (e) {
                return []
            }
        }

        return Array.isArray(filter_option.value) ? filter_option.value : []
    }

    return []
}

const clear_all_filters = () => {
    emit('update:model_value', {})
}
</script>
