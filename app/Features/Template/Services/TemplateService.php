<?php

namespace App\Features\Template\Services;

use Illuminate\Support\Str;

class TemplateService {
    const string low_stock_notification         = "low_stock_notification";
    const string daily_sales_report             = "daily_sales_report";


    //==================================================================================================================
    // Get template with replacing tags
    //==================================================================================================================
    public static function render_template_with_tags(string $template, array $tags) : string {
        $path_to_templates = app_path("/Features/Template/TemplatesHTML/$template.html");

        $html_content = file_get_contents($path_to_templates);
        $html_content = Str::replace('""', '', $html_content);
        $html_content = str_replace("\n", '', $html_content);

        if ($tags) {
            foreach ($tags as $tag) {
                $key   = array_key_first($tag);
                $value = $tag[$key];

                $html_content = Str::replace(
                    $key,
                    $value,
                    $html_content
                );
            }
        }


        return response($html_content)->content();
    }
}
