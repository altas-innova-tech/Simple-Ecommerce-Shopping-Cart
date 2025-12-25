<template>
    <div class="relative">
        <!--        <Fields-->
        <!--            :disabled="disabled"-->
        <!--            :label="label"-->
        <!--            :mode="mode"-->
        <!--            :name="name"-->
        <!--            :name_error="name_error"-->
        <!--            class="bg-gray-100"-->
        <!--        >-->
        <FieldText
            :on_change="handle_phone_change"
            v-bind="passThroughProps"
        >
            <template v-slot:mode-view>
                <Icon
                    :name="copied ? 'Check' : 'Copy'"
                    @click="copy_to_clipboard"
                    :class="{ 'text-green-600': copied, 'text-gray-500': !copied }"
                    class="absolute pointer-events-auto cursor-pointer right-2 top-1/2 w-4 h-4 transform -translate-y-1/2 hover:bg-gray-100 rounded transition-colors"
                />
            </template>
        </FieldText>
        <!--        </Fields>-->
    </div>
</template>

<script lang="ts" setup>
import {computed, ref} from 'vue'
import {CommonFieldsPropertiesInterface} from "./index";
import FieldText from "./field-text.vue";
import Icon from "../icon.vue";
import {copyText, useCopyFlag} from "@/utils/clipboard";

export interface PhoneFieldInterface extends CommonFieldsPropertiesInterface {
    on_change?: (value: string | number | boolean) => void; // Make sure this is defined
}

const props = withDefaults(defineProps<PhoneFieldInterface>(), {
    type: "tel",
    placeholder: "06XXXXXXXX"
})

// Morocco phone patterns: No validation - accept any input

const handle_phone_change = (val: string | number | boolean) => {
    // normalize input: keep only digits, ensure it starts with 0
    const raw = String(val ?? '').replace(/\D/g, '') // Remove all non-digits

    // Pass normalized value upward
    if (props.on_change && typeof props.on_change === 'function') {
        props.on_change(raw)
    }
}

const copied = ref<boolean>(false)
const {setCopied} = useCopyFlag()
const copy_to_clipboard = async () => {
    const text = (() => {
        const raw = (props.value ?? '') as any
        const str = typeof raw === 'string' ? raw : String(raw || '')
        const t = (str || '').toString().trim()
        if (t) return t
        const n = (props as any).name as string | undefined
        let el: HTMLInputElement | null = null
        if (n) {
            el = document.querySelector(`input[name="${n}"]`)
            if (!el) el = document.getElementById(n) as HTMLInputElement | null
        }
        return (el?.value || '').toString().trim()
    })()
    const ok = await copyText(text)
    if (ok) setCopied(v => copied.value = v)
}

// CRITICAL FIX: Exclude on_change from passThroughProps to prevent override
const passThroughProps = computed(() => {
    const {on_change, ...rest} = props
    return {
        ...rest,
        type: 'tel',
        placeholder: props.placeholder ?? '06XXXXXXXX',
    }
})
</script>

<style scoped lang="scss">
.relative {
    position: relative;
}
</style>
