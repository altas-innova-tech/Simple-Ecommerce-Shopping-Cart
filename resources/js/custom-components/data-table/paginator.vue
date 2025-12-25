<template>
    <Pagination
        v-slot="{ page }"
        show-edges
        :total="total_computed"
        :sibling-count="1"
        :default-page="current_page"
        :items-per-page="per_page"
    >
        <PaginationList v-slot="{ items }" class="flex items-center gap-1">
            <PaginationFirst @click="handle_page_click(1)"/>
            <PaginationPrev @click="handle_page_click(Math.max(1, current_page - 1))"/>

            <template v-for="(item, index) in items" :key="index">
                <PaginationListItem
                    v-if="item.type === 'page'"
                    :value="item.value"
                    as-child
                    @click="handle_page_click(item.value)"
                >
                    <Button class="w-8 h-8 p-0" :variant="item.value === page ? 'default' : 'outline'">
                        {{ item.value }}
                    </Button>
                </PaginationListItem>
                <PaginationEllipsis v-else :index="index"/>
            </template>

            <PaginationNext
                @click="handle_page_click(Math.min(Math.ceil(total_computed / props.per_page), current_page + 1))"/>
            <PaginationLast @click="handle_page_click(Math.ceil(total_computed / props.per_page))"/>
        </PaginationList>
    </Pagination>
</template>

<script setup lang="ts">
import {Button} from '@/components/ui/button';

import {
    Pagination,
    PaginationEllipsis,
    PaginationFirst,
    PaginationLast,
    PaginationList,
    PaginationListItem,
    PaginationNext,
    PaginationPrev,
} from '@/components/ui/pagination';
import {PaginationInterface, PaginationPagesInterface} from "./index";
import {computed} from "vue";
import {router} from "@inertiajs/vue3";
import {route} from "ziggy-js";

interface PaginatorInterface extends PaginationInterface {
    // Add any additional props if needed
}

const props = defineProps<PaginatorInterface>()

const pages = computed<PaginationPagesInterface[]>(() => props.pages)
const total_computed = computed<number>(() => props.total || 0)

const handle_page_click = (page_number: number) => {
    const totalPages = Math.ceil(total_computed.value / props.per_page);

    if (page_number < 1 || page_number > totalPages) {
        return;
    }

    const target_page = pages.value.find(page => page.page === page_number);

    if (target_page?.url) {
        const params = {
            ...route().params,
            page: page_number.toString()
        }

        router.visit(route(route().current(), params));
    } else {
        const params = {
            ...route().params,
            page: page_number.toString()
        }

        router.visit(route(route().current(), params));
    }
}
</script>
