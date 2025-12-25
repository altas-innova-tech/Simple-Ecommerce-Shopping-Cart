<template>
    <Fields
        :disabled="disabled"
        :label="label"
        :mode="mode"
        :name="name"
    >
        <div v-if="mode === 'list' || mode === 'list_deleted'">
            <FieldBadge :label="displayValue"></FieldBadge>
        </div>


        <div
            v-else
            class="relative"
        >
            <Popover>
                <PopoverTrigger as-child>
                    <Button
                        variant="outline"
                        :class="cn(
                            'w-[280px] justify-start text-left font-normal',
                            !dateValue && 'text-muted-foreground',
                        )"
                    >
                        <CalendarIcon class="mr-2 h-4 w-4"/>
                        {{ dateValue ? df.format(dateValue.toDate(getLocalTimeZone())) : "Pick a date" }}
                    </Button>
                </PopoverTrigger>
                <PopoverContent class="flex w-auto flex-col gap-y-2 p-2">
                    <Select
                        @update:model-value="(v) => {
                            if (!v) return;
                            dateValue = today(getLocalTimeZone()).add({ days: Number(v) });
                        }"
                    >
                        <SelectTrigger>
                            <SelectValue placeholder="Select"/>
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem v-for="item in items" :key="item.value" :value="item.value.toString()">
                                {{ item.label }}
                            </SelectItem>
                        </SelectContent>
                    </Select>
                    <Calendar
                        v-model="dateValue"
                    />
                </PopoverContent>
            </Popover>

            <input
                :name="name"
                :value="dateValue?.toString() || ''"
                type="hidden"
            />
        </div>
    </Fields>
</template>

<script setup lang="ts">
import {DateFormatter, type DateValue, getLocalTimeZone, parseDate} from '@internationalized/date'
import {CalendarIcon} from 'lucide-vue-next'

import {computed, ref, watch} from 'vue'
import {cn} from '@/lib/utils'
import {Button} from '@/components/ui/button'
import {Calendar} from '@/components/ui/calendar'
import {Popover, PopoverContent, PopoverTrigger} from '@/components/ui/popover'
import {Select, SelectContent, SelectItem, SelectTrigger, SelectValue} from '@/components/ui/select'
import Fields from "../fields.vue"
import FieldBadge from "../field-badge.vue"
import {CommonFieldsPropertiesInterface} from "../index";

export interface DateFieldInterface extends CommonFieldsPropertiesInterface {
    value?: string | DateValue
}

const props = defineProps<DateFieldInterface>()
// Remove emit since you're not using v-model pattern

const df = new DateFormatter('en-US', {
    dateStyle: 'long',
})

const items = [
    {value: 0, label: 'Today'},
    {value: 1, label: 'Tomorrow'},
    {value: 3, label: 'In 3 days'},
    {value: 7, label: 'In a week'},
    {value: 31, label: 'In a month'},
    {value: 365, label: 'In a year'},
]

const dateValue = ref<DateValue>()

// Convert ISO string to DateValue
const convertToDateValue = (value: string | DateValue | undefined): DateValue | undefined => {
    if (!value) return undefined

    if (typeof value === 'string') {
        try {
            // Extract date part from ISO string (YYYY-MM-DD)
            const dateOnly = value.split('T')[0]
            return parseDate(dateOnly)
        } catch (error) {
            console.error('Error parsing date:', error)
            return undefined
        }
    }

    return value
}

// Initialize dateValue from props
dateValue.value = convertToDateValue(props.value)

// Watch for prop changes
watch(() => props.value, (newValue) => {
    dateValue.value = convertToDateValue(newValue)
})

// Computed property for display value in list mode
const displayValue = computed(() => {
    if (!dateValue.value) return ''
    return df.format(dateValue.value.toDate(getLocalTimeZone()))
})
</script>
