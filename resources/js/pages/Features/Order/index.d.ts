import {FeaturesListInterface, FeaturesViewInterface} from "@/custom-components/data-table";
import {OptionsInterface} from "@/custom-components/fields";


export interface OrderInterface {
    id: number;
    cle: string;

    user_id: string;

    created_at: string;
    updated_at: string;
    deleted_at: string;
}


export interface OrderListInterface extends FeaturesListInterface<OrderInterface> {

}


export interface OrderViewInterface extends FeaturesViewInterface<OrderInterface> {
    member_types: OptionsInterface[];
    departments: OptionsInterface[];
}
