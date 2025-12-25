import {FeaturesListInterface, FeaturesViewInterface} from "@/custom-components/data-table";
import {OptionsInterface} from "@/custom-components/fields";


export interface ProductInterface {
    id: number;
    cle: string;

    name: string;
    price: number;
    stock_quantity: string;

    created_at: string;
    updated_at: string;
    deleted_at: string;
}


export interface ProductListInterface extends FeaturesListInterface<ProductInterface> {

}


export interface ProductViewInterface extends FeaturesViewInterface<ProductInterface> {
    member_types: OptionsInterface[];
    departments: OptionsInterface[];
}
