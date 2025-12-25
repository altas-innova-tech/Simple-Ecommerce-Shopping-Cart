<template>
    <Fields
        :disabled="disabled"
        :label="label"
        :mode="mode"
        :name="name"
    >
        <div v-if="mode === 'list' || mode === 'list_deleted'">
            <FieldBadge :label="value"></FieldBadge>
        </div>

        <div v-else class="relative">
            <Popover>
                <PopoverTrigger as-child>
                    <Button
                        variant="outline"
                        :class="
          cn(
            'w-[280px] justify-start text-left font-normal',
            !internal_value && 'text-muted-foreground',
          )
        "
                    >
                        <Calendar class="mr-2 h-4 w-4"/>
                        <template v-if="internal_value?.start">
                            <template v-if="internal_value?.end">
                                {{
                                    formatter.custom(toDate(internal_value.start), {
                                        dateStyle: "medium",
                                    })
                                }}
                                -
                                {{
                                    formatter.custom(toDate(internal_value.end), {
                                        dateStyle: "medium",
                                    })
                                }}
                            </template>

                            <template v-else>
                                {{
                                    formatter.custom(toDate(internal_value.start), {
                                        dateStyle: "medium",
                                    })
                                }}
                            </template>
                        </template>
                        <template v-else>
                            Pick a date
                        </template>
                    </Button>
                </PopoverTrigger>
                <PopoverContent class="w-auto p-0">
                    <RangeCalendarRoot
                        v-slot="{ weekDays }"
                        v-model="internal_value"
                        v-model:placeholder="placeholder"
                        :min-value="min_date_value"
                        :max-value="max_date_value"
                        class="p-3"
                    >
                        <div
                            class="flex flex-col gap-y-4 mt-4 sm:flex-row sm:gap-x-4 sm:gap-y-0"
                        >
                            <div class="flex flex-col gap-4">
                                <div class="flex items-center justify-between">
                                    <button
                                        :class="
                  cn(
                    buttonVariants({ variant: 'outline' }),
                    'h-7 w-7 bg-transparent p-0 opacity-50 hover:opacity-100',
                  )
                "
                                        @click="update_month('first', -1)"
                                    >
                                        <ChevronLeft class="h-4 w-4"/>
                                    </button>
                                    <div :class="cn('text-sm font-medium')">
                                        {{
                                            formatter.fullMonthAndYear(
                                                toDate(first_month.value),
                                            )
                                        }}
                                    </div>
                                    <button
                                        :class="
                  cn(
                    buttonVariants({ variant: 'outline' }),
                    'h-7 w-7 bg-transparent p-0 opacity-50 hover:opacity-100',
                  )
                "
                                        @click="update_month('first', 1)"
                                    >
                                        <ChevronRight class="h-4 w-4"/>
                                    </button>
                                </div>
                                <RangeCalendarGrid>
                                    <RangeCalendarGridHead>
                                        <RangeCalendarGridRow>
                                            <RangeCalendarHeadCell
                                                v-for="day in weekDays"
                                                :key="day"
                                                class="w-full"
                                            >
                                                {{ day }}
                                            </RangeCalendarHeadCell>
                                        </RangeCalendarGridRow>
                                    </RangeCalendarGridHead>
                                    <RangeCalendarGridBody>
                                        <RangeCalendarGridRow
                                            v-for="(
                    weekDates, index
                  ) in first_month.rows"
                                            :key="`weekDate-${index}`"
                                            class="mt-2 w-full"
                                        >
                                            <RangeCalendarCell
                                                v-for="weekDate in weekDates"
                                                :key="weekDate.toString()"
                                                :date="weekDate"
                                            >
                                                <RangeCalendarCellTrigger
                                                    :day="weekDate"
                                                    :month="first_month.value"
                                                />
                                            </RangeCalendarCell>
                                        </RangeCalendarGridRow>
                                    </RangeCalendarGridBody>
                                </RangeCalendarGrid>
                            </div>
                            <div class="flex flex-col gap-4">
                                <div class="flex items-center justify-between">
                                    <button
                                        :class="
                  cn(
                    buttonVariants({ variant: 'outline' }),
                    'h-7 w-7 bg-transparent p-0 opacity-50 hover:opacity-100',
                  )
                "
                                        @click="update_month('second', -1)"
                                    >
                                        <ChevronLeft class="h-4 w-4"/>
                                    </button>
                                    <div :class="cn('text-sm font-medium')">
                                        {{
                                            formatter.fullMonthAndYear(
                                                toDate(second_month.value),
                                            )
                                        }}
                                    </div>

                                    <button
                                        :class="
                  cn(
                    buttonVariants({ variant: 'outline' }),
                    'h-7 w-7 bg-transparent p-0 opacity-50 hover:opacity-100',
                  )
                "
                                        @click="update_month('second', 1)"
                                    >
                                        <ChevronRight class="h-4 w-4"/>
                                    </button>
                                </div>
                                <RangeCalendarGrid>
                                    <RangeCalendarGridHead>
                                        <RangeCalendarGridRow>
                                            <RangeCalendarHeadCell
                                                v-for="day in weekDays"
                                                :key="day"
                                                class="w-full"
                                            >
                                                {{ day }}
                                            </RangeCalendarHeadCell>
                                        </RangeCalendarGridRow>
                                    </RangeCalendarGridHead>
                                    <RangeCalendarGridBody>
                                        <RangeCalendarGridRow
                                            v-for="(
                    weekDates, index
                  ) in second_month.rows"
                                            :key="`weekDate-${index}`"
                                            class="mt-2 w-full"
                                        >
                                            <RangeCalendarCell
                                                v-for="weekDate in weekDates"
                                                :key="weekDate.toString()"
                                                :date="weekDate"
                                            >
                                                <RangeCalendarCellTrigger
                                                    :day="weekDate"
                                                    :month="second_month.value"
                                                />
                                            </RangeCalendarCell>
                                        </RangeCalendarGridRow>
                                    </RangeCalendarGridBody>
                                </RangeCalendarGrid>
                            </div>
                        </div>
                    </RangeCalendarRoot>
                </PopoverContent>
            </Popover>

            <input
                :name="name"
                :value="formatted_value"
                type="hidden"
            />
        </div>
    </Fields>
</template>

<script setup lang="ts">
import {CalendarDate, type DateValue, isEqualMonth, parseDate} from '@internationalized/date'
import {Calendar, ChevronLeft, ChevronRight} from 'lucide-vue-next'
import {type DateRange, RangeCalendarRoot, useDateFormatter} from 'reka-ui'
import {createMonth, type Grid, toDate} from 'reka-ui/date'
import {computed, ref, type Ref, watch} from 'vue'
import {cn} from '@/lib/utils'
import {Button, buttonVariants} from '@/components/ui/button'
import {Popover, PopoverContent, PopoverTrigger} from '@/components/ui/popover'
import {
    RangeCalendarCell,
    RangeCalendarCellTrigger,
    RangeCalendarGrid,
    RangeCalendarGridBody,
    RangeCalendarGridHead,
    RangeCalendarGridRow,
    RangeCalendarHeadCell,
} from '@/components/ui/range-calendar'
import Fields from "../fields.vue";
import {CommonFieldsPropertiesInterface} from "../index";
import FieldBadge from "../field-badge.vue";

export interface DateRangeFieldInterface extends CommonFieldsPropertiesInterface {
    // Direct value prop (string format: "YYYY-MM-DD,YYYY-MM-DD")
    value?: string

    // Additional configuration
    locale?: string
    min?: string  // Optional min date (YYYY-MM-DD)
    max?: string  // Optional max date (YYYY-MM-DD)
}

const props = withDefaults(defineProps<DateRangeFieldInterface>(), {
    locale: 'en-US',
    value: undefined,
    min: undefined,
    max: undefined,
})

const emit = defineEmits<{
    'update:value': [value: string]
    'change': [value: string]
}>()

// Helper function to convert string date to DateValue
const string_to_date_value = (dateStr: string | undefined): DateValue | undefined => {
    if (!dateStr) return undefined

    // Handle ISO string format (YYYY-MM-DD)
    if (dateStr.match(/^\d{4}-\d{2}-\d{2}$/)) {
        return parseDate(dateStr)
    }

    // Handle other formats by converting to Date first
    const date = new Date(dateStr)
    if (isNaN(date.getTime())) return undefined

    return new CalendarDate(
        date.getFullYear(),
        date.getMonth() + 1,
        date.getDate()
    )
}

// Helper function to convert DateValue to string
const date_value_to_string = (dateValue: DateValue | undefined): string => {
    if (!dateValue) return ''

    const date = toDate(dateValue)
    return date.toISOString().split('T')[0] // Returns YYYY-MM-DD format
}

// Parse value string to DateRange
const parse_value = (valueStr: string | undefined): DateRange | undefined => {
    if (!valueStr) return undefined

    const parts = valueStr.split(',')
    if (parts.length !== 2) return undefined

    const start = string_to_date_value(parts[0].trim())
    const end = string_to_date_value(parts[1].trim())

    if (start && end) {
        return {start, end}
    }

    return undefined
}

// Convert DateRange to value string
const format_date_range = (range: DateRange | undefined): string[] => {
    if (!range?.start || !range?.end) return ''

    const start_str = date_value_to_string(range.start)
    const end_str = date_value_to_string(range.end)

    return `${start_str},${end_str}`
}

// Create default value from props
const create_default_value = (): DateRange => {
    const parsed = parse_value(props.value)

    if (parsed) {
        return parsed
    }

    // Fallback to current date + 7 days if no props provided
    const today = new CalendarDate(new Date().getFullYear(), new Date().getMonth() + 1, new Date().getDate())
    return {
        start: today,
        end: today.add({days: 7})
    }
}

// Internal value that syncs with string props
const internal_value = ref<DateRange>(create_default_value())

// Computed value for the hidden input
const formatted_value = computed(() => format_date_range(internal_value.value))

// Computed min/max date values
const min_date_value = computed(() => string_to_date_value(props.min))
const max_date_value = computed(() => string_to_date_value(props.max))

// Watch for prop changes and update internal value
watch(
    () => props.value,
    (newValue) => {
        const parsed = parse_value(newValue)
        if (parsed) {
            internal_value.value = parsed
        }
    },
    {immediate: true}
)

// Emit changes to parent as string
watch(
    internal_value,
    (newValue) => {
        const formatted = format_date_range(newValue)
        emit('update:value', formatted)
        emit('change', formatted)
    },
    {deep: true}
)

// Rest of the component logic
const formatter = useDateFormatter(props.locale)

const placeholder = ref(internal_value.value.start) as Ref<DateValue>
const second_month_placeholder = ref(internal_value.value.end) as Ref<DateValue>

const first_month = ref(
    createMonth({
        dateObj: placeholder.value,
        locale: props.locale,
        fixedWeeks: true,
        weekStartsOn: 0,
    }),
) as Ref<Grid<DateValue>>

const second_month = ref(
    createMonth({
        dateObj: second_month_placeholder.value,
        locale: props.locale,
        fixedWeeks: true,
        weekStartsOn: 0,
    }),
) as Ref<Grid<DateValue>>

const update_month = (reference: 'first' | 'second', months: number) => {
    if (reference === 'first') {
        placeholder.value = placeholder.value.add({months})
    } else {
        second_month_placeholder.value = second_month_placeholder.value.add({
            months,
        })
    }
}

watch(placeholder, (_placeholder) => {
    first_month.value = createMonth({
        dateObj: _placeholder,
        weekStartsOn: 0,
        fixedWeeks: false,
        locale: props.locale,
    })
    if (isEqualMonth(second_month_placeholder.value, _placeholder)) {
        second_month_placeholder.value = second_month_placeholder.value.add({
            months: 1,
        })
    }
})

watch(second_month_placeholder, (_secondMonthPlaceholder) => {
    second_month.value = createMonth({
        dateObj: _secondMonthPlaceholder,
        weekStartsOn: 0,
        fixedWeeks: false,
        locale: props.locale,
    })
    if (isEqualMonth(_secondMonthPlaceholder, placeholder.value))
        placeholder.value = placeholder.value.subtract({months: 1})
})

// Update placeholders when internal value changes
watch(internal_value, (newValue) => {
    if (newValue.start) {
        placeholder.value = newValue.start
    }
    if (newValue.end) {
        second_month_placeholder.value = newValue.end
    }
})
</script>
