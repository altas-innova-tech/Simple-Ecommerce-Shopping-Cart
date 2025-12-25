<?php

namespace App\Core\Interfaces;

interface JobInterface {
    public function process() : void;
}
