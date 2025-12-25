<template>
    <Fields :label="label" :mode="mode" :name="name">
        <div v-if="mode === 'list' || mode === 'list_deleted'">
            <span>{{ format_date_time_mode_list(value) }}</span>
        </div>
        <div v-else>
            <VueDatePicker
                v-model="date_time_value"
                :preview-format="format_display_date"
                class="text-field"
                month-name-format="long"
                time-picker-inline
                @update:model-value="handle_date_time_change"
            />
            <input
                :name="name"
                :value="stocked_date_time"
                type="hidden"
            />
        </div>
    </Fields>
</template>

<script lang="ts" setup>
import {CommonFieldsPropertiesInterface} from "../index";
import {computed, onMounted, ref} from "vue";
import Fields from "../fields.vue";

export interface DateTimePickerFieldInterface extends CommonFieldsPropertiesInterface {
}

const props = defineProps<DateTimePickerFieldInterface>();

const parse_date = (value: any): Date => {
    if (!value) return new Date();
    if (value instanceof Date) return value;

    const parsed_date = new Date(value);
    return isNaN(parsed_date.getTime()) ? new Date() : parsed_date;
};

const date_time_value = ref(parse_date(props.value));
const stocked_date_time = ref("");

const pad_zero = (num: number): string => num.toString().padStart(2, '0');

const format_date_time = (date: Date | null | undefined) => {
    const safe_date = date ? parse_date(date) : new Date();

    const day = pad_zero(safe_date.getDate());
    const month = pad_zero(safe_date.getMonth() + 1);
    const year = safe_date.getFullYear();
    const hours = pad_zero(safe_date.getHours());
    const minutes = pad_zero(safe_date.getMinutes());
    const seconds = pad_zero(safe_date.getSeconds());

    return {
        display: `${day}-${month}-${year}`,
        stock: `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`
    };
};

const formatted_date_time = computed(() => {
    return format_date_time(date_time_value.value).display;
});

const format_display_date = (date: Date) => format_date_time(date).display;

const handle_date_time_change = (new_value: Date) => {
    const formatted_value = format_date_time(new_value);
    stocked_date_time.value = formatted_value.stock;
    props.on_change?.(new_value as string);
};


function format_date_time_mode_list(date_time: string): string {
    // Create a new Date object from the input date_time string
    const date = new Date(date_time);

    // Format the date parts
    const day = String(date.getDate()).padStart(2, '0'); // Get the day and pad with zero if needed
    const month = String(date.getMonth() + 1).padStart(2, '0'); // Get the month (0-11) and add 1
    const year = date.getFullYear(); // Get the full year

    // Format the time parts
    const hours = String(date.getHours()).padStart(2, '0'); // Get the hours and pad with zero if needed
    const minutes = String(date.getMinutes()).padStart(2, '0'); // Get the minutes and pad with zero if needed

    // Construct the formatted date string
    return `${day}-${month}-${year} at ${hours}:${minutes}`;
}


onMounted(() => {
    const formatted_value = format_date_time(date_time_value.value);
    stocked_date_time.value = formatted_value.stock;
});
</script>


<style>
.dp__theme_light {
    --dp-border-color: transparent;
    --dp-menu-border-color: transparent;
    --dp-border-color-hover: transparent;
    --dp-border-color-focus: transparent;
}

.dp__pointer {
    @apply py-0 m-auto;
}
</style>
