import {
    FeaturesListInterface,
    FeaturesViewInterface,
} from '@/custom-components/data-table';
import { ProductInterface } from '@/pages/Features/Product';

export interface OrderProductInterface {
    id: number;
    key: string;

    quantity: number;
    price: number;
    order_id: number;
    product_id: number;

    product?: ProductInterface;

    created_at: string;
    updated_at: string;
    deleted_at: string;
}

export interface OrderProductListInterface extends FeaturesListInterface<OrderProductInterface> {}

export interface OrderProductViewInterface extends FeaturesViewInterface<OrderProductInterface> {
}
