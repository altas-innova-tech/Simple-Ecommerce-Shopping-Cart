<?php

namespace App\Core\Traits\Builders;

trait BuildersMethodsTrait {

    public static function new() : static {
        return new static();
    }



    public function label(string $label) : static {
        $this->label = $label;

        return $this;
    }



    public function permission(string $permission) : static {
        $this->permission = $permission;

        return $this;
    }



    public function value(string|int|array|null $value) : static {
        $this->value = $value;

        return $this;
    }



    public function values(array $values) : static {
        $this->values = $values;

        return $this;
    }



    public function color(string $color) : static {
        $this->color = $color;

        return $this;
    }



    public function type(string $type) : static {
        $this->type = $type;

        return $this;
    }



    public function button_confirme() : static {
        $this->button_confirme = true;

        return $this;
    }



    public function button_confirme_label(string $label) : static {
        $this->button_confirme_label = $label;

        return $this;
    }



    public function button_confirme_destroy_label(string $model_label) : static {
        $this->button_confirme_label = "Do you want to destroy <i style='font-weight: 700;'>$model_label</i> ?";

        return $this;
    }



    public function button_confirme_destroy_multi_label(string $model_label) : static {
        $this->button_confirme_label = "Do you want to destroy $model_label ?";

        return $this;
    }



    public function button_confirme_description(string $description) : static {
        $this->button_confirme_description = $description;

        return $this;
    }



    public function button_confirme_destroy_description() : static {
        $this->button_confirme_description = "<i class='text-red-500 text-lg'>This Action can be undone. It will temporarily remove your data from our database.</i>";

        return $this;
    }



    public function icon(string $icon) : static {
        $this->icon = $icon;

        return $this;
    }



    public function route(string $name, array $params = []) : static {
        $this->url = route($name, $params);

        return $this;
    }



    public function url(string $url) : static {
        $this->url = $url;

        return $this;
    }



    public function searchable() : static {
        $this->searchable = true;

        return $this;
    }



    public function triable() : static {
        $this->triable = true;

        return $this;
    }



    public function name(string $name) : static {
        $this->name = $name;

        return $this;
    }



    public function component(string $component) : static {
        $this->component = $component;

        return $this;
    }



    public function method(string $method) : static {
        $this->method = $method;

        return $this;
    }



    public function get() : array {
        return [
            "label" => $this->label,
            "color" => $this->color,
            "icon"  => $this->icon,
            "url"   => $this->url,
            "type"  => $this->type,
        ];
    }
}
