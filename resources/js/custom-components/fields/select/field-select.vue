<template>
    <Fields
        :label="label"
        :mode="mode"
        :name="name"
    >
        <div v-if="mode === 'list' || mode === 'list_deleted'">
            <!-- TODO : if nedeed -->
        </div>

        <div class="w-full" v-else>
            <!-- Hidden input to store the selected value -->
            <input
                type="hidden"
                :value="hidden_input_value"
                :name="name"
            />

            <Popover v-model:open="open">
                <PopoverTrigger asChild>
                    <Button
                        variant="outline"
                        role="combobox"
                        :aria-expanded="open"
                        class="w-full justify-between min-h-10"
                        :class="{ 'h-auto': multiple && selected_options.length > 0 }"
                    >
                        <div class="flex items-center gap-2 flex-1 flex-wrap">
                            <!-- Multiple selection with tags -->
                            <template v-if="multiple && selected_options.length > 0">
                                <div
                                    v-for="option in selected_options"
                                    :key="get_option_key(option)"
                                    class="flex items-center gap-1 bg-secondary text-secondary-foreground px-2 py-1 rounded-md text-sm"
                                >
                                    <div
                                        v-if="option.color"
                                        class="w-2 h-2 rounded-full"
                                        :style="{ backgroundColor: option.color }"
                                    />
                                    <Icon
                                        :name="option.icon"
                                    />
                                    <span>{{ option.label }}</span>
                                    <button
                                        type="button"
                                        @click.stop="remove_option(option)"
                                        class="ml-1 hover:bg-secondary-foreground/20 rounded-full p-0.5"
                                    >
                                        <X class="h-3 w-3"/>
                                    </button>
                                </div>
                            </template>

                            <!-- Single selection -->
                            <template v-else-if="!multiple && selectedOption">
                                <Icon v-if="selectedOption?.icon" :name="selectedOption.icon" class="h-4 w-4"/>
                                <div
                                    v-if="selectedOption?.color"
                                    class="w-3 h-3 rounded-full"
                                    :style="{ backgroundColor: selectedOption.color }"
                                />
                                <span>{{ selectedOption?.label }}</span>
                            </template>

                            <!-- Placeholder -->
                            <span v-else class="text-muted-foreground">{{ placeholder }}</span>
                        </div>
                        <ChevronsUpDown class="ml-2 h-4 w-4 shrink-0 opacity-50"/>
                    </Button>
                </PopoverTrigger>
                <PopoverContent class="p-0"
                                :style="{ width: 'var(--radix-popover-trigger-width)', minWidth: 'var(--radix-popover-trigger-width)' }">
                    <Command>
                        <CommandInput
                            v-model="search_query"
                            placeholder="Search options..."
                            class="h-9"
                        />
                        <CommandEmpty>No option found.</CommandEmpty>
                        <CommandList ref="listRef" style="max-height: 300px; overflow-y: auto" @scroll="onScroll">
                            <CommandGroup>
                                <CommandItem
                                    v-for="option in visible_options"
                                    :key="get_option_key(option)"
                                    :value="option.label"
                                    @select="select_option(option)"
                                >
                                    <Check
                                        :class="[
                                        'mr-2 h-4 w-4',
                                        is_selected(option) ? 'opacity-100' : 'opacity-0'
                                    ]"
                                    />
                                    <div class="flex items-center gap-2 flex-1">
                                        <Icon v-if="option.icon" :name="option.icon" class="h-4 w-4"/>
                                        <div
                                            v-if="option.color"
                                            class="w-3 h-3 rounded-full"
                                            :style="{ backgroundColor: option.color }"
                                        />
                                        <span>{{ option.label }}</span>
                                    </div>
                                </CommandItem>
                                <div ref="sentinelRef" v-if="visibleOptionsCount < filtered_options.length"
                                     class="py-2 text-center text-xs text-muted-foreground">Loading more...
                                </div>
                            </CommandGroup>
                        </CommandList>
                    </Command>
                </PopoverContent>
            </Popover>
        </div>
    </Fields>
</template>

<script setup lang="ts">
import {computed, nextTick, onBeforeUnmount, onMounted, ref, watch} from 'vue'
import {Check, ChevronsUpDown, X} from 'lucide-vue-next'
import {Command, CommandEmpty, CommandGroup, CommandInput, CommandItem, CommandList,} from '@/components/ui/command'
import {Popover, PopoverContent, PopoverTrigger,} from '@/components/ui/popover'
import {Button} from '@/components/ui/button'
import Fields from "../fields.vue";
import {CommonFieldsPropertiesInterface, OptionsInterface} from "../index";
import Icon from "../../icon.vue";

export interface SelectFieldInterface extends CommonFieldsPropertiesInterface {
    multiple?: boolean;
    value: (string | number) | (string | number)[] | null;
}

const props = withDefaults(defineProps<SelectFieldInterface>(), {
    multiple: false,
    placeholder: 'Select option...',
    name: 'select_value'
})

const open = ref(false)
const search_query = ref('')
const internal_value = ref(props.value)

// Update internal value when props.value changes
watch(() => props.value, (newValue) => {
    internal_value.value = newValue
}, {immediate: true})

const selectedOption = computed(() => {
    if (props.multiple || !internal_value.value) return null

    return props.values.find(option => {
        if (typeof option.value === 'object' && typeof internal_value.value === 'object') {
            return JSON.stringify(option.value) === JSON.stringify(internal_value.value)
        }
        return option.value === internal_value.value
    })
})

const selected_options = computed(() => {
    if (!props.multiple || !internal_value.value) return []

    const values = Array.isArray(internal_value.value) ? internal_value.value : [internal_value.value]

    return props.values.filter(option => {
        return values.some(val => {
            if (typeof option.value === 'object' && typeof val === 'object') {
                return JSON.stringify(option.value) === JSON.stringify(val)
            }
            return option.value === val
        })
    })
})

const hidden_input_value = computed(() => {
    if (!internal_value.value) return ''

    if (Array.isArray(internal_value.value)) {
        return JSON.stringify(internal_value.value)
    }

    if (typeof internal_value.value === 'object') {
        return JSON.stringify(internal_value.value)
    }

    return String(internal_value.value)
})

const INITIAL_BATCH_SIZE = 50
const INCREMENT_BATCH_SIZE = 100
const visibleOptionsCount = ref(INITIAL_BATCH_SIZE)
const listRef = ref<HTMLElement | null>(null)
const sentinelRef = ref<HTMLElement | null>(null)
let io: IntersectionObserver | null = null

const debouncedSearch = ref('')
let searchTimeout: number | undefined

watch(search_query, (v) => {
    if (searchTimeout) clearTimeout(searchTimeout as any)
    searchTimeout = setTimeout(() => {
        debouncedSearch.value = v
    }, 150) as any
}, {immediate: true})

const filtered_options = computed(() => {
    const q = debouncedSearch.value?.toLowerCase()
    if (!q) return props.values

    return props.values.filter(option =>
        option.label?.toLowerCase().includes(q)
    )
})

const visible_options = computed(() => {
    return filtered_options.value.slice(0, visibleOptionsCount.value)
})

const onScroll = (e: Event) => {
    // keep as a safety fallback in case IO fails
    const target = e.target as HTMLElement
    if (!target) return
    const threshold = 60
    const nearBottom = target.scrollTop + target.clientHeight >= target.scrollHeight - threshold
    if (nearBottom && visibleOptionsCount.value < filtered_options.value.length) {
        visibleOptionsCount.value += INCREMENT_BATCH_SIZE
    }
}

watch([() => search_query.value, () => open.value], () => {
    // Reset list size when search changes or popover opens
    visibleOptionsCount.value = INITIAL_BATCH_SIZE
    nextTick(() => {
        if (listRef.value) listRef.value.scrollTop = 0
    })
    // attach or detach observer based on open state
    if (open.value) {
        attachObserver()
    } else {
        if (io) {
            io.disconnect();
            io = null
        }
    }
})

watch(() => props.values, () => {
    // Reset when options source changes
    visibleOptionsCount.value = INITIAL_BATCH_SIZE
    if (open.value) attachObserver()
}, {deep: true})

const keyCache = new Map<any, string>()
const get_option_key = (option: OptionsInterface) => {
    const v = option.value as any
    const cached = keyCache.get(v)
    if (cached) return cached
    const k = typeof v === 'object' ? JSON.stringify(v) : String(v)
    keyCache.set(v, k)
    return k
}

const selectedKeysSet = computed(() => {
    const set = new Set<string>()
    if (!internal_value.value) return set

    const values = props.multiple
        ? (Array.isArray(internal_value.value) ? internal_value.value : [internal_value.value])
        : [internal_value.value]

    values.forEach((val) => {
        const key = typeof val === 'object' ? JSON.stringify(val) : String(val)
        set.add(key)
    })

    return set
})

const is_selected = (option: OptionsInterface) => {
    const key = get_option_key(option)
    return selectedKeysSet.value.has(key)
}

const select_option = (option: OptionsInterface) => {
    if (props.multiple) {
        const current_values = Array.isArray(internal_value.value) ? internal_value.value : []

        // Check if already selected
        const is_already_selected = current_values.some(val => {
            if (typeof option.value === 'object' && typeof val === 'object') {
                return JSON.stringify(option.value) === JSON.stringify(val)
            }
            return option.value === val
        })

        if (is_already_selected) {
            // Remove from selection
            internal_value.value = current_values.filter(val => {
                if (typeof option.value === 'object' && typeof val === 'object') {
                    return JSON.stringify(option.value) !== JSON.stringify(val)
                }
                return option.value !== val
            })
        } else {
            // Add to selection
            internal_value.value = [...current_values, option.value]
        }

        if (props.on_change) {
            props.on_change(selected_options.value)
        }
    } else {
        internal_value.value = option.value

        if (props.on_change) {
            props.on_change(option)
        }

        open.value = false
        search_query.value = ''
    }
}

const remove_option = (option: OptionsInterface) => {
    if (!props.multiple) return

    const current_values = Array.isArray(internal_value.value) ? internal_value.value : []

    internal_value.value = current_values.filter(val => {
        if (typeof option.value === 'object' && typeof val === 'object') {
            return JSON.stringify(option.value) !== JSON.stringify(val)
        }
        return option.value !== val
    })

    if (props.on_change) {
        props.on_change(selected_options.value)
    }
}

function attachObserver() {
    // disconnect previous
    if (io) {
        io.disconnect()
        io = null
    }
    if (!listRef.value || !sentinelRef.value) return
    io = new IntersectionObserver((entries) => {
        const entry = entries[0]
        if (entry.isIntersecting) {
            if (visibleOptionsCount.value < filtered_options.value.length) {
                visibleOptionsCount.value += INCREMENT_BATCH_SIZE
            }
        }
    }, {
        root: listRef.value,
        rootMargin: '0px 0px 200px 0px',
        threshold: 0.01
    })
    io.observe(sentinelRef.value)
}

onMounted(() => {
    if (open.value) attachObserver()
})

onBeforeUnmount(() => {
    if (io) io.disconnect()
})
</script>
