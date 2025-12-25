import {ButtonsInterface} from "../render-buttons";
import {CommonFieldsPropertiesInterface} from "../fields";

export interface ActionsInterface extends ButtonsInterface {
    type: "primary" | "secondary" | "destructive" | "outline" | "ghost" | "link" | "icon";
    permission?: string;
}

export interface PaginationHeadersInterface {
    name: string;
    label: string;
    component: string;
    searchable: boolean;
    triable: boolean;
}

export interface PaginationPagesInterface {
    page: number;
    url: string;
    is_current: boolean;
}

export interface PaginationUrlsInterface {
    first: string | null;
    prev: string | null;
    next: string | null;
    last: string | null;
}

export interface PaginationInterface {
    current_page: number;
    per_page: string;
    total: number;
    last_page: number;
    pages: PaginationPagesInterface[];
    urls: PaginationUrlsInterface;
}

export interface PaginationItemsInterface<ItemInterface = any> {
    item: ItemInterface;
    row_actions: ActionsInterface[];
    click_action: ActionsInterface[];
}

export interface DataTableInterface<ItemInterface = any> {
    filters?: CommonFieldsPropertiesInterface[];
    order_by: string;
    order_direction: string;
    headers: PaginationHeadersInterface[];
    items: PaginationItemsInterface<ItemInterface>[];
    pagination: PaginationInterface;
}

export interface FeaturesListInterface<ItemInterface = any> {
    actions: ActionsInterface[];
    actions_multi: ActionsInterface[];
    table_builder: DataTableInterface<ItemInterface>
}

export interface FeaturesViewInterface<ItemInterface = any> {
    actions: ActionsInterface[];
    model: ItemInterface;
    permission: string;
}


export interface FilterOptionInterface {
    name: string;
    label: string;
    values: CommonFieldsPropertiesInterface[];
    value: (number | string)[] | string;
}

export interface DataTableFiltersInterface {
    filter_options: FilterOptionInterface[];
    model_value?: Record<string, (string | number)[]>;
}

export interface DataTableFilterInterface {
    filter_option: FilterOptionInterface
    model_value?: (string | number)[]
}
