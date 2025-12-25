<?php

namespace App\Core\Constants;

class PermissionConstants {
    const string            permission                     = "permission";
    const string            permission_list                = "list";
    const string            permission_view                = "view";
    const string            permission_create              = "create";
    const    string         permission_edit                = "edit";
    const        string     permission_store               = "store";
    const string            permission_update              = "update";
    const string            permission_destroy             = "destroy";
    const string            permission_force_destroy       = "force_destroy";
    const string            permission_destroy_multi       = "destroy_multi";
    const string            permission_force_destroy_multi = "force_destroy_multi";
    const string            permission_restore             = "restore";
    const string            permission_restore_multi       = "restore_multi";
    const   string          permission_export_multi        = "export_multi";
    const    string         permission_export              = "export";

    const array             permissions = [
        self::permission_list,
        self::permission_view,
        self::permission_create,
        self::permission_store,
        self::permission_edit,
        self::permission_update,
        self::permission_destroy,
        self::permission_destroy_multi,
    ];
}
