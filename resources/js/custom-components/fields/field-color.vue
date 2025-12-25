<template>
    <Fields
        :label="label"
        :mode="mode"
        :name="name"
    >
        <div
            v-if="mode === 'list' || mode === 'list_deleted'"
            :class="['p-2 h-2 w-2 rounded-full ring-1 ring-gray-300', get_color(selected_color)]"
        ></div>


        <div v-else class="grid sm:grid-cols-12 grid-cols-6 gap-2">
              <span
                  v-if="mode === 'view'"
                  :class="['p-2 w-8 h-8 rounded-md ring-1 ring-gray-300', get_color(selected_color)]"
              ></span>


            <template
                v-for="color in colors"
                v-else
            >
            <span
                :class="['relative flex justify-center items-center cursor-pointer p-2 w-8 h-8 rounded-md ring-1 ring-gray-300', get_color(color)]"
                @click="()=> selected_color = color"
            >
                <Icon
                    v-if="color === selected_color"
                    class="absolute bg-gray-50/50 w-3 h-3 rounded-full p-1"
                    icon="check"
                ></Icon>
            </span>
            </template>
        </div>

        <input :name="name" :value="selected_color" type="hidden"/>
    </Fields>
</template>

<script lang="ts" setup>

import {CommonFieldsPropertiesInterface} from "./index";
import {ref} from "vue";
import Fields from "./fields.vue";
import Icon from "../icon.vue";

export interface FieldColorsInterface extends CommonFieldsPropertiesInterface {
}

const props = defineProps<FieldColorsInterface>()

const colors = [
    "black",
    "white",
    "gray",
    "red",
    "orange",
    "yellow",
    "lime",
    "green",
    "teal",
    "cyan",
    "blue",
    "indigo",
    "violet",
    "purple",
    "fuchsia",
    "pink",
]

const get_color = (color: string) => {
    if (["black", "white"]?.includes(color)) {
        return `bg-${color}`
    }

    return `bg-${color}-500`
}

const selected_color = ref<string>(props.value)
</script>

<style scoped lang="scss">
</style>
