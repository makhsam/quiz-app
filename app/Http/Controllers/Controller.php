<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function data(mixed $items = []): array
    {
        return ['items' => json_decode(json_encode($items), true)];
    }
}
