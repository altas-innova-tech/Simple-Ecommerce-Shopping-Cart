import fieldConstants from "../../constants/component-constants";

export interface OptionsInterface {
    label?: string;
    value: string | number | object;
    key?: string | number | object;
    color?: string;
    icon?: string;
    url?: string;
    items?: OptionsInterface[];
}

export type ComponentTypes = fieldConstants;

export interface CommonFieldsPropertiesInterface {
    component?: ComponentTypes;
    mode?: string;
    type?: "text" | "number" | "email" | "password" | "tel";
    placeholder?: string;
    label?: string;
    detail?: string;
    value?: string | number | object;
    name?: string;
    name_error?: string;
    color?: string;
    icon?: string;
    disabled?: boolean;
    on_change?: (value: string | number | boolean | OptionsInterface) => void;
    values?: OptionsInterface[];
    start?: "string";
    end?: "string";
}
