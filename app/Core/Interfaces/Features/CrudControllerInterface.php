<?php

namespace App\Core\Interfaces\Features;

use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

interface CrudControllerInterface {
    public static function get_model_class() : string;



    public static function get_form_request_class() : string;



    public function list(...$params) : RedirectResponse|Response;



    public function trashed(...$params) : RedirectResponse|Response;



    public function view(...$params) : RedirectResponse|Response;



    public function create() : RedirectResponse|Response;



    public function update(...$params) : RedirectResponse;



    public function destroy(...$params) : RedirectResponse;



    public function destroy_multi(...$params) : RedirectResponse;



    public function restore(...$params) : RedirectResponse;



    public function restore_multi(...$params) : RedirectResponse;



    public function force_destroy(...$params) : RedirectResponse;



    public function force_destroy_multi(...$params) : RedirectResponse;



    public function export(...$params) : BinaryFileResponse|RedirectResponse;



    public function export_multi(...$params) : BinaryFileResponse|RedirectResponse;
}
