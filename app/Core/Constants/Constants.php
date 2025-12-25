<?php

namespace App\Core\Constants;


class Constants {
    //==================================================================================================================
    // guards
    //==================================================================================================================

    //==================================================================================================================
    // guards
    //==================================================================================================================
    const string  token      = "token";
    const string  status     = "status";
    const string  code       = "code";
    const string  message    = "message";
    const string  data       = "data";
    const string  params     = "params";
    const string  name       = "name";
    const string  label      = "label";
    const string  icon       = "icon";
    const string  color      = "color";
    const string  value      = "value";
    const string  table_name = "table_name";
    const string  per_page   = "per_page";
    const string  page       = "page";
    const string  filters    = "filters";
    const string  email      = "email";

    //==================================================================================================================
    // Validation codes
    //==================================================================================================================
    const int     code_unverified_email_address        = 800;
    const int     code_invalid_token                   = 498;
    const int     code_user_credentials_not_matched_db = 980;
    const string  key                                  = "key";
    const string  keys                                 = "keys";
    const string  mode                                 = "mode";
    const string  title_page                           = "title_page";
    //==================================================================================================================
    // Base keys
    //==================================================================================================================
    const string key_controller_class     = "controller_class";
    const string key_render_service_class = "render_service_class";
    const string key_action_class         = "action_class";
    const string key_quick_menu_class     = "quick_menu_class";
    const string key_breadcrumb_class     = "breadcrumb_class";
    const string key_title_page_class     = "title_page_class";
    const string key_export_class         = "export_class";
    const string key_permission           = "permission";
    const string key_model                = "model";
    const string key_model_class          = "model_class";
    const string key_feature              = "feature";
    const string key_actions              = "actions";
    const string key_breadcrumbs          = "breadcrumbs";
    const string key_quick_menu           = "quick_menu";
    const string key_title_page           = "title_page";
    const string key_actions_multi        = "actions_multi";
    const string key_table_builder        = "table_builder";
    const string key_model_key            = "model_key";

    //==================================================================================================================
    // Butons constants // TODO : move to file Components constants if we have multi
    //==================================================================================================================
    const string       button_type_default     = "default";
    const string       button_type_secondary   = "secondary";
    const string       button_type_destructive = "destructive";
    const string       button_type_ghost       = "ghost";
    const string       button_type_link        = "link";
    const string       button_type_icon        = "icon";
    const string       button_type_submit      = "submit";
    const string       button_type_button      = "button";
    const   string     text_color              = "text_color";
}
