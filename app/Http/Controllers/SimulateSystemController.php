<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class SimulateSystemController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('system/Index');
    }
}