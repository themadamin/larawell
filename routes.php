<?php

use App\Http\Controllers\DashboardController;

$router->get('/', [DashboardController::class, 'index']);
$router->get('/chirps/{id}', [DashboardController::class, 'index']);