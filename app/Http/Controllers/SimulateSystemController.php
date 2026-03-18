<?php

namespace App\Http\Controllers;

use App\Application\UseCases\GetAllDepartments;
use Inertia\Inertia;

class SimulateSystemController extends Controller
{
    public function __construct(private GetAllDepartments $getAllDepartments) {}

    public function __invoke()
    {
        return Inertia::render('system/Index', [
            'serverDepartments' => $this->getAllDepartments->execute(),
            'serverUsers' => [],
            'serverTickets' => [],
        ]);
    }
}