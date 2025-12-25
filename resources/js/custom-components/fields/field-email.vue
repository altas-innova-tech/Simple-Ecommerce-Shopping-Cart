<template>
    <div class="relative">
        <FieldText
            :on_change="handle_email_change"
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
    type: "email",
    placeholder: "email@example.com"
})

const handle_email_change = (val: string | number | boolean) => {
    if (props.on_change && typeof props.on_change === 'function') {
        props.on_change(String(val ?? ''))
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
        type: 'email',
        placeholder: props.placeholder ?? '06XXXXXXXX',
    }
})
</script>

<style scoped lang="scss">
.relative {
    position: relative;
}
</style>
