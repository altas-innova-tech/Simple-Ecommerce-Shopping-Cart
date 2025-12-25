<template>
    <Fields
        :disabled="disabled"
        :label="label"
        :mode="mode"
        :name="name"
        class="bg-gray-100"
        :detail="detail"
    >
        <div v-if="([permissionConstants.trashed, permissionConstants.list]).includes(mode)" class="relative">
            <span>{{ display_list }}</span>
        </div>

        <div v-else class="space-y-0 py-0">
            <div v-for="(item, idx) in localPhones" :key="item.id" class="relative flex items-center gap-1 px-1">
                <FieldPhone
                    :name="`${name}[]`"
                    :name_error="`${name}.${idx}`"
                    :placeholder="placeholder"
                    :value="item.value"
                    :mode="mode"
                    :on_change="(v) => updatePhone(item.id, String(v))"
                />


                <CustomButton
                    class="px-2 py-1"
                    icon="SquareMinus"
                    type="destructive"
                    @click="removePhone(item.id)"
                    v-if="idx > 0 && ([permissionConstants.edit, permissionConstants.create]).includes(mode)"
                ></CustomButton>
            </div>

            <CustomButton
                icon="SquarePlus"
                type="outline"
                @click="addPhone"
                class="ml-2"
                v-if="([permissionConstants.edit, permissionConstants.create]).includes(mode)"
            ></CustomButton>
        </div>


        <input
            :name="name"
            :value="JSON.stringify(localPhones?.map(phone => phone.value))"
            type="hidden"
        />
    </Fields>
</template>

<script lang="ts" setup>
import {computed, ref, watch} from 'vue'
import {CommonFieldsPropertiesInterface} from "./index";
import Fields from "./fields.vue";
import FieldPhone from "./field-phone.vue";
import CustomButton from "../render-buttons/buttons/custom-button.vue";
import permissionConstants from "@/constants/permission-constants";

export interface PhonesFieldInterface extends CommonFieldsPropertiesInterface {
    // value can be string or array of strings; we will treat single string as one phone
}

type PhoneItem = { id: number; value: string }

const props = withDefaults(defineProps<PhonesFieldInterface>(), {
    placeholder: '06XXXXXXXX'
})

const emitChangeUp = (phones: string[]) => {
    if (props.on_change) {
        props.on_change(phones)
    }
}

const toArray = (val: any): string[] => {
    if (Array.isArray(val)) return val.map(v => String(v ?? ''))
    if (val === undefined || val === null || val === '') return []
    return [String(val)]
}

const nextId = ref<number>(1)
const makeItem = (value: string = ''): PhoneItem => ({id: nextId.value++, value})

const localPhones = ref<PhoneItem[]>(toArray(props.value).map(v => makeItem(v)))
if (localPhones.value.length === 0) localPhones.value.push(makeItem(''))

watch(() => props.value, (nv) => {
    // Rebuild items from incoming values but keep fresh ids to avoid key/index issues
    const values = toArray(nv)
    localPhones.value = values.length ? values.map(v => makeItem(v)) : [makeItem('')]
})

const updatePhone = (id: number, v: string) => {
    const item = localPhones.value.find(it => it.id === id)
    if (item) item.value = v
    emitChangeUp(normalized(localPhones.value.map(it => it.value)))
}

const addPhone = () => {
    localPhones.value.push(makeItem(''))
    emitChangeUp(normalized(localPhones.value.map(it => it.value)))
}

const removePhone = (id: number) => {
    const idx = localPhones.value.findIndex(it => it.id === id)
    if (idx !== -1) localPhones.value.splice(idx, 1)
    if (localPhones.value.length === 0) localPhones.value.push(makeItem(''))
    emitChangeUp(normalized(localPhones.value.map(it => it.value)))
}

const normalized = (arr: string[]) => arr
    .map(s => String(s || '').trim())
    .filter((s, i, a) => s !== '' && a.indexOf(s) === i)

const display_list = computed(() => toArray(props.value).filter(Boolean).join(', '))
</script>

<style scoped lang="scss">
</style>
