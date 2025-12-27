export interface ButtonsInterface {
    disabled?: boolean;
    label?: string;
    color?: string;
    icon?: string;
    icon_right?: string;
    method?: string;
    url?: string;
    type:
        | 'primary'
        | 'secondary'
        | 'destructive'
        | 'outline'
        | 'ghost'
        | 'link'
        | 'icon';
    button_confirme?: boolean;
    button_add_to_cart?: boolean;
    model?: object;
    button_confirme_label?: string;
    button_confirme_description?: string;
}
