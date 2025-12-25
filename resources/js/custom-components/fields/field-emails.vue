<template>
    <Fields
        :disabled="disabled"
        :label="label"
        :mode="mode"
        :name="name"
        class="bg-gray-100"
    >
        <!-- List / Deleted Mode -->
        <div v-if="([permissionConstants.trashed, permissionConstants.list]).includes(mode)" class="relative">
            <span>{{ display_list }}</span>
        </div>

        <!-- Edit Mode -->
        <div v-else class="space-y-2 py-1">
            <div
                v-for="(item, idx) in localEmails"
                :key="item.id"
                class="relative flex items-center gap-2 px-1"
            >
                <FieldEmail
                    :name="`${name}[]`"
                    :name_error="`${name}.${idx}`"
                    :placeholder="placeholder"
                    :value="item.value"
                    :mode="mode"
                    :on_change="(v) => updateEmail(item.id, String(v))"
                />

                <CustomButton
                    class="px-2 py-1"
                    icon="SquareMinus"
                    type="destructive"
                    @click="removeEmail(item.id)"
                    v-if="idx > 0"
                />
            </div>

            <CustomButton
                icon="SquarePlus"
                type="outline"
                @click="addEmail"
                class="ml-2"
                v-if="mode === permissionConstants.create"
            />
        </div>

        <!-- Hidden input to submit values -->
        <input
            :name="name"
            :value="JSON.stringify(localEmails?.map(email => email.value))"
            type="hidden"
        />
    </Fields>
</template>

<script lang="ts" setup>
import {computed, ref, watch} from 'vue'
import {CommonFieldsPropertiesInterface} from "./index";
import Fields from "./fields.vue";
import CustomButton from "../render-buttons/buttons/custom-button.vue";
import FieldEmail from "./field-email.vue";
import permissionConstants from "@/constants/permission-constants";

export interface EmailsFieldInterface extends CommonFieldsPropertiesInterface {
    // value can be string or array of strings; treat single string as one email
}

type EmailItem = { id: number; value: string }

const props = withDefaults(defineProps<EmailsFieldInterface>(), {
    placeholder: 'example@example.com'
})

const emitChangeUp = (emails: string[]) => {
    if (props.on_change) {
        props.on_change(emails)
    }
}

const toArray = (val: any): string[] => {
    if (Array.isArray(val)) return val.map(v => String(v ?? ''))
    if (val === undefined || val === null || val === '') return []
    return [String(val)]
}

const nextId = ref<number>(1)
const makeItem = (value: string = ''): EmailItem => ({id: nextId.value++, value})

const localEmails = ref<EmailItem[]>(toArray(props.value).map(v => makeItem(v)))
if (localEmails.value.length === 0) localEmails.value.push(makeItem(''))

watch(() => props.value, (nv) => {
    const values = toArray(nv)
    localEmails.value = values.length ? values.map(v => makeItem(v)) : [makeItem('')]
})

const updateEmail = (id: number, v: string) => {
    const item = localEmails.value.find(it => it.id === id)
    if (item) item.value = v
    emitChangeUp(normalized(localEmails.value.map(it => it.value)))
}

const addEmail = () => {
    localEmails.value.push(makeItem(''))
    emitChangeUp(normalized(localEmails.value.map(it => it.value)))
}

const removeEmail = (id: number) => {
    const idx = localEmails.value.findIndex(it => it.id === id)
    if (idx !== -1) localEmails.value.splice(idx, 1)
    if (localEmails.value.length === 0) localEmails.value.push(makeItem(''))
    emitChangeUp(normalized(localEmails.value.map(it => it.value)))
}

const normalized = (arr: string[]) => arr
    .map(s => String(s || '').trim())
    .filter((s, i, a) => s !== '' && a.indexOf(s) === i)

const display_list = computed(() => toArray(props.value).filter(Boolean).join(', '))
</script>
