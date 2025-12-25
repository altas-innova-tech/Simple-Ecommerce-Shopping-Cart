<template>
    <div v-if="selected_items?.length > 1" class="flex gap-1">
        <RenderActions :actions="actions_multi"></RenderActions>
    </div>

    <template v-else>
        <div class="justify-self-start">
            <DataTableFilter
                :filter_options="filters"
                :model_value="filtrations"
                @update:model_value="handle_filters_changed"
            />
        </div>

        <div class="flex items-center justify-between">
            <Input
                placeholder="Search here..."
                type="text"
                class="text-field w-[300px]"
                @input.prevent="
                    (event: InputEvent) =>
                        (search_text = (event.target as HTMLInputElement)
                            ?.value)
                "
            />

            <div class="flex gap-1">
                <RenderActions :actions="actions"></RenderActions>
            </div>
        </div>
    </template>

    <Table class="border border-gray-100">
        <TableHeader>
            <TableRow>
                <TableHead class="w-fit">
                    <Checkbox
                        :checked="is_all_selected"
                        :indeterminate="is_indeterminate"
                        @update:checked="handle_select_all"
                    />
                </TableHead>

                <TableHead
                    v-for="header in headers"
                    class="cursor-pointer gap-1"
                    @click="handle_tri(header)"
                >
                    <div class="flex gap-1">
                        {{ header.label }}

                        <ChevronsUpDown
                            v-if="header.triable && header.name !== order_by"
                            class="h-5 w-5"
                        ></ChevronsUpDown>
                        <ChevronDown
                            v-if="
                                header.name === order_by &&
                                order_direction === 'desc'
                            "
                            class="h-5 w-5"
                        ></ChevronDown>
                        <ChevronUp
                            v-if="
                                header.name === order_by &&
                                order_direction === 'asc'
                            "
                            class="h-5 w-5"
                        ></ChevronUp>
                    </div>
                </TableHead>

                <!--  For Actions  -->
                <TableHead class="!w-[10px]"></TableHead>
            </TableRow>
        </TableHeader>

        <!--  Table Body -->
        <TableBody>
            <TableRow v-if="!items?.length">
                <TableCell
                    :colspan="100"
                    class="py-10 text-center text-lg font-semibold text-gray-400 italic"
                >
                    No Items found
                </TableCell>
            </TableRow>

            <TableRow v-else v-for="(item, index) in items" :key="index">
                <TableCell class="w-fit">
                    <Checkbox
                        :checked="selected_items.includes(item.item.key)"
                        @update:checked="
                            (value) => handle_select_item(value, item.item)
                        "
                    />
                </TableCell>

                <TableCell v-for="header in headers" class="">
                    <RenderComponents
                        :component="header.component"
                        :value="item.item?.[header.name]"
                        mode="list"
                    ></RenderComponents>
                </TableCell>

                <!-- DropdownMenu for Actions -->
                <TableCell class="!w-[10px]">
                    <DropdownMenu>
                        <DropdownMenuTrigger
                            class="rounded-sm hover:bg-gray-300"
                        >
                            <Ellipsis class="h-5 w-5"></Ellipsis>
                        </DropdownMenuTrigger>

                        <DropdownMenuContent>
                            <DropdownMenuLabel>Actions</DropdownMenuLabel>
                            <DropdownMenuSeparator />

                            <RenderActions
                                :actions="item.row_actions"
                                direction="col"
                            ></RenderActions>
                        </DropdownMenuContent>
                    </DropdownMenu>
                </TableCell>
            </TableRow>
        </TableBody>
    </Table>

    <div class="mt-1.5 grid w-full grid-cols-5 px-1">
        <span class="col-span-2">
            Showing
            <span class="font-semibold">{{
                (pagination.current_page - 1) * pagination.per_page
            }}</span>
            to
            <span class="font-semibold">{{
                pagination.per_page * pagination.current_page
            }}</span>
            of
            <span class="font-semibold">{{ pagination.total }}</span> results.
        </span>

        <div class="flex items-center gap-1">
            Rows per page
            <Select v-model="selected_per_page">
                <SelectTrigger class="w-[80px]">
                    <SelectValue />
                </SelectTrigger>
                <SelectContent>
                    <SelectGroup>
                        <SelectItem value="10"> 10 </SelectItem>
                        <SelectItem value="50"> 50 </SelectItem>
                        <SelectItem value="100"> 100 </SelectItem>
                    </SelectGroup>
                </SelectContent>
            </Select>
        </div>

        <Paginator
            v-bind="pagination"
            class="col-span-2 justify-self-end"
            :per_page="selected_per_page"
        ></Paginator>
    </div>
</template>

<script setup lang="ts">
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import {
    ChevronDown,
    ChevronsUpDown,
    ChevronUp,
    Ellipsis,
} from 'lucide-vue-next';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import Paginator from './paginator.vue';
import { Checkbox } from '@/components/ui/checkbox';
import {
    ActionsInterface,
    FeaturesListInterface,
    PaginationHeadersInterface,
    PaginationInterface,
    PaginationItemsInterface,
} from './index';
import { computed, ref, watch } from 'vue';
import RenderActions from '../render-actions/render-actions.vue';
import { router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { Input } from '@/components/ui/input';
import { DataTableHelpers } from './data-table-helpers';
import RenderComponents from '@/custom-components/fields/render-components.vue';
import DataTableFilter from '@/custom-components/data-table/data-table-filter.vue';

const props = defineProps<FeaturesListInterface>();
const headers = computed<PaginationHeadersInterface[]>(
    () => props.table_builder.headers,
);
const items = computed<PaginationItemsInterface[]>(
    () => props.table_builder.items,
);
const pagination = computed<PaginationInterface>(
    () => props.table_builder.pagination,
);
const actions = computed<ActionsInterface[]>(() => props.actions);
const actions_multi = computed<ActionsInterface[]>(() => props.actions_multi);

// States
const selected_per_page = ref<string>(pagination.value.per_page?.toString());
const search_text = ref<string>('');
const order_by = computed<string>(() => props.table_builder.order_by);
const order_direction = computed<string>(
    () => props.table_builder.order_direction,
);
const { selected_items } = DataTableHelpers();

const handle_tri = (header: PaginationHeadersInterface) => {
    const is_current_header = header.name === order_by.value;
    const is_direction_desc = order_direction.value === 'desc';
    let params = {
        ...route().params,
    };

    if (!is_current_header) {
        params = {
            ...params,
            order_by: header.name,
            order_direction: 'desc',
        };
    } else {
        params = {
            ...params,
            order_by: header.name,
            order_direction: is_direction_desc ? 'asc' : 'desc',
        };
    }

    router.visit(route(route().current(), params));
};

const handle_select_item = (value: boolean, item: any) => {
    if (value) {
        selected_items.value.push(item.key);
    } else {
        const index = selected_items.value.indexOf(item.key);
        if (index > -1) {
            selected_items.value.splice(index, 1);
        }
    }
};

const is_all_selected = computed(() => {
    return (
        items.value.length > 0 &&
        selected_items.value.length === items.value.length
    );
});

const is_indeterminate = computed(() => {
    return (
        selected_items.value.length > 0 &&
        selected_items.value.length < items.length
    );
});

const handle_select_all = (checked: boolean) => {
    if (checked) {
        selected_items.value.splice(
            0,
            selected_items.value.length,
            ...items.value.map((item) => item.item.key),
        );
    } else {
        selected_items.value.splice(0, selected_items.value.length);
    }
};

// Filtration
const filters = computed<ActionsInterface[]>(() => props.table_builder.filters);
const filtrations = ref<Record<string, (string | number)[]>>({});

const handle_filters_changed = (
    newFilters: Record<string, (string | number)[]>,
    filter_name: string,
) => {
    filtrations.value = newFilters;

    const queryParams = new URLSearchParams();

    // Add filters that exist and have values
    Object.entries(newFilters).forEach(([key, value]) => {
        if (Array.isArray(value) && value.length > 0) {
            const arrayString = `[${value.join(', ')}]`;
            queryParams.append(key, arrayString);
        } else if (!Array.isArray(value)) {
            queryParams.append(key, String(value));
        }
    });

    // Get current route params and remove old filter parameters
    const currentParams = { ...route().params };

    // Remove any existing filter parameters that are not in newFilters
    Object.keys(currentParams).forEach((key) => {
        if (!(key in newFilters)) {
            delete currentParams[key];
        }
    });

    // Merge cleaned params with new query params
    const params = {
        ...currentParams,
        ...Object.fromEntries(queryParams),
    };

    router.visit(route(route().current(), params), {
        preserveState: true,
    });
};

watch(selected_per_page, () => {
    const params = {
        ...route().params,
        per_page: selected_per_page.value,
        page: 1,
    };

    router.visit(route(route().current(), params));
});

watch(search_text, () => {
    let params = {
        search_text: search_text.value,
        page: 1,
    };

    router.visit(route(route().current(), params), {
        preserveState: true,
    });
});
</script>
