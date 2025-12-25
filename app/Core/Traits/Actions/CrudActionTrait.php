<?php

namespace App\Core\Traits\Actions;

use App\Core\Base\Builders\Action\ActionBuilder;
use App\Core\Base\Model\BaseModel;

trait CrudActionTrait {
    //==================================================================================================================
    //== Actions for List
    //==================================================================================================================
    public function get_actions_list(array $params = []) : ActionBuilder {
        $action_create  = $this->action_create($params);

        return ActionBuilder
            ::new()
            ->add_item($action_create);
    }



    public function get_row_actions_list(BaseModel $model, array $params = []) : ActionBuilder {
        $commun_action_view          = $this->action_view($model, $params);
        $commun_action_edit          = $this->action_edit($model, $params);
        $commun_action_destroy       = $this->action_destroy($model, $params);


        return ActionBuilder::new()
                            ->add_item($commun_action_view)
                            ->add_item($commun_action_edit)
                            ->add_item($commun_action_destroy);
    }



    public function get_actions_multi_list(array $params = []) : ActionBuilder {
        $action_destroy_multi       = $this->action_destroy_multi($params);


        return ActionBuilder::new()
                            ->add_item($action_destroy_multi);
    }


    //==================================================================================================================
    //== Actions for Trashed
    //==================================================================================================================
    public function get_row_actions_trashed(BaseModel $model, array $params = []) : ActionBuilder {
        $action_restore       = $this->action_restore($model, $params);


        return ActionBuilder::new()
                            ->add_item($action_restore);
    }









    //==================================================================================================================
    //== Actions for Create
    //==================================================================================================================
    public function get_actions_create(BaseModel $model = null, array $params = []) : ActionBuilder {
        $action_list  = $this->action_list($params);
        $action_store = $this->action_store($model, $params);

        return ActionBuilder::new()
                            ->add_item($action_list)
                            ->add_item($action_store);
    }


    //==================================================================================================================
    //== Actions for View
    //==================================================================================================================
    public function get_actions_view(BaseModel $model, array $params = []) : ActionBuilder {
        $action_list = $this->action_list($params);
        $action_edit = $this->action_edit($model, $params);

        return ActionBuilder::new()
                            ->add_item($action_list)
                            ->add_item($action_edit);
    }


    //==================================================================================================================
    //== Actions for Edit
    //==================================================================================================================
    public function get_actions_edit(BaseModel $model, array $params = []) : ActionBuilder {
        $action_list   = $this->action_list($params);
        $action_update = $this->action_update($model, $params);

        return ActionBuilder::new()
                            ->add_item($action_list)
                            ->add_item($action_update);
    }


    //==================================================================================================================
    //== Action row click data-table builder
    //==================================================================================================================
    public function get_row_click_action_list(BaseModel $model, array $params = []) : ActionBuilder {
        $action_view = $this->action_view($model, $params);

        return ActionBuilder::new()
                            ->add_item($action_view);
    }
}
