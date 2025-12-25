<template>
    <FieldText
        :on_change="on_change"
        v-bind="props"
        :type="type_password"
    >
        <template v-slot:mode-view>
            <Icon
                :name="type_password_icon"
                @click="handle_see_hide_password"
                class="absolute pointer-events-auto cursor-pointer right-2 top-1/2 w-4 h-4 transform -translate-y-1/2 hover:bg-gray-100 rounded transition-colors"
            />
        </template>
    </FieldText>
</template>

<script lang="ts" setup>
import {ref} from 'vue'
import {CommonFieldsPropertiesInterface} from "./index";
import FieldText from "./field-text.vue";
import Icon from "../icon.vue";

export interface PasswordFieldInterface extends CommonFieldsPropertiesInterface {
}

const props = withDefaults(defineProps<PasswordFieldInterface>(), {
    type: 'password',
});

const type_password = ref<string>(props.type);
const type_password_icon = ref<string>("Eye");

const handle_see_hide_password = () => {
    const is_type_password = type_password.value === 'password';
    type_password.value = is_type_password ? 'text' : 'password';
    type_password_icon.value = is_type_password ? 'EyeOff' : 'Eye';
};
</script>

<style scoped lang="scss">
.relative {
    position: relative;
}
</style>
