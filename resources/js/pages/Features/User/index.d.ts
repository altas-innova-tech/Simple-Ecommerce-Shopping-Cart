import {
    FeaturesListInterface,
    FeaturesViewInterface,
} from '@/custom-components/data-table';

export interface UserInterface {
    id: number;
    key: string;

    name: string;
    email: string;

    created_at: string;
    updated_at: string;
    deleted_at: string;
}

export interface UserListInterface extends FeaturesListInterface<UserInterface> {}

export interface UserViewInterface extends FeaturesViewInterface<UserInterface> {}
