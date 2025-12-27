import {
    FeaturesListInterface,
    FeaturesViewInterface,
} from '@/custom-components/data-table';
import { OptionsInterface } from '@/custom-components/fields';
import { UserInterface } from '@/pages/Features/User';

export interface OrderInterface {
    id: number;
    key: string;

    user_id: string;
    status: 'CART' | 'COMPLETED';
    user: UserInterface;

    created_at: string;
    updated_at: string;
    deleted_at: string;
}

export interface OrderListInterface extends FeaturesListInterface<OrderInterface> {}

export interface OrderViewInterface extends FeaturesViewInterface<OrderInterface> {
    status: OptionsInterface[];
}
