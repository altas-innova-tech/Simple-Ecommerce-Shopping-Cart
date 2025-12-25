<template>
    <div :class="`rounded-lg bg-${get_color}-50 border border-${get_color}-500 p-3`">
        <div class="flex">
            <div class="flex-shrink-0">
                <Icon :class="`h-5 w-5`" :color="get_color" :icon="get_icon"/>
            </div>
            <div class="ml-3">
                <p :class="`text-sm font-medium text-${get_color}-500`">{{ message }}</p>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>

import {TYPE} from "vue-toastification";
import Icon from "../icon.vue";
import {computed} from "vue";

interface AlertInterface {
    message: string;
    type: "success" | "error" | "warning" | "info";
}

const get_color = computed<string>(() => {
    switch (props.type) {
        case TYPE.INFO:
            return "blue"
        case TYPE.SUCCESS:
            return "green"
        case TYPE.ERROR:
            return "red"
        case TYPE.WARNING:
            return "yellow"
    }
})

const get_icon = computed<string>(() => {
    switch (props.type) {
        case TYPE.INFO:
            return "circle-info"
        case TYPE.SUCCESS:
            return "circle-check"
        case TYPE.ERROR:
            return "circle-exclamation"
        case TYPE.WARNING:
            return "circle-exclamation"
    }
})


const props = withDefaults(defineProps<AlertInterface>(), {
    type: TYPE.INFO
})
</script>
