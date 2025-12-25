<template>
    <Popover>
        <PopoverTrigger as-child>
            <Button variant="outline" size="sm" class="h-8 border-dashed">
                <PlusCircle class="mr-2 h-4 w-4"/>
                {{ title }}
                <template v-if="selected_values.size > 0">
                    <Separator orientation="vertical" class="mx-0 h-4"/>
                    <Badge
                        variant="secondary"
                        class="rounded-sm px-1 font-normal lg:hidden"
                    >
                        {{ selected_values.size }}
                    </Badge>
                    <div class="hidden space-x-1 lg:flex">
                        <Badge
                            v-if="selected_values.size > 2"
                            variant="secondary"
                            class="rounded-sm font-normal"
                        >
                            {{ selected_values.size }} selected
                        </Badge>

                        <template v-else>
                            <Badge
                                v-for="option in options
                  .filter((option) => selected_values.has(option.value))"
                                :key="option.value"
                                variant="secondary"
                                class="rounded-sm font-normal"
                            >
                                {{ option.label }}
                            </Badge>
                        </template>
                    </div>
                </template>
            </Button>
        </PopoverTrigger>
        <PopoverContent class="w-[200px] p-0" align="start">
            <Command>
                <CommandInput :placeholder="title"/>
                <CommandList>
                    <CommandEmpty>No results found.</CommandEmpty>
                    <CommandGroup>
                        <CommandItem
                            v-for="option in options"
                            :key="option.value"
                            :value="option"
                            @select="() => {
                const is_selected = selected_values.has(option.value)
                const newS_slected_values = new Set(selected_values)

                if (is_selected) {
                  newS_slected_values.delete(option.value)
                } else {
                  newS_slected_values.add(option.value)
                }

                const filter_values = Array.from(newS_slected_values)
                emit('update:model_value', filter_values.length ? filter_values : undefined)
              }"
                        >
                            <div
                                :class="cn(
                  'mr-2 flex h-4 w-4 items-center justify-center rounded-sm border border-primary',
                  selected_values.has(option.value)
                    ? 'bg-primary text-primary-foreground'
                    : 'opacity-50 [&_svg]:invisible',
                )"
                            >
                                <Check :class="cn('h-4 w-4')"/>
                            </div>
                            <component :is="option.icon" v-if="option.icon" class="mr-2 h-4 w-4 text-muted-foreground"/>
                            <span>{{ option.label }}</span>
                            <span v-if="facets?.get(option.value)"
                                  class="ml-auto flex h-4 w-4 items-center justify-center font-mono text-xs">
                {{ facets.get(option.value) }}
              </span>
                        </CommandItem>
                    </CommandGroup>

                    <template v-if="selected_values.size > 0">
                        <CommandSeparator/>
                        <CommandGroup>
                            <CommandItem
                                :value="{ label: 'Clear filters' }"
                                class="justify-center text-center"
                                @select="() => emit('update:model_value', undefined, filter_option.name)"
                            >
                                Clear filters
                            </CommandItem>
                        </CommandGroup>
                    </template>
                </CommandList>
            </Command>
        </PopoverContent>
    </Popover>
</template>

<script setup lang="ts">
import {computed} from 'vue'
import {Check, PlusCircle} from 'lucide-vue-next'

import {cn} from '@/lib/utils'
import {Badge} from '@/components/ui/badge'
import {Button} from '@/components/ui/button'
import {
    Command,
    CommandEmpty,
    CommandGroup,
    CommandInput,
    CommandItem,
    CommandList,
    CommandSeparator,
} from '@/components/ui/command'
import {Popover, PopoverContent, PopoverTrigger,} from '@/components/ui/popover'
import {Separator} from '@/components/ui/separator'
import {DataTableFilterInterface} from "./index";


const props = defineProps<DataTableFilterInterface>()
const emit = defineEmits<{
    'update:model_value': [value: (string | number)[] | undefined]
}>()

const selected_values = computed(() => {
    if (Array.isArray(props.model_value)) {
        return new Set(props.model_value.map(v => String(v)))
    }
    return new Set<string>()
})

const title = computed(() => props.filter_option.label)
const options = computed(() =>
    props.filter_option.values.map(value => ({
        label: value.label,
        value: String(value.value)
    }))
)
</script>
