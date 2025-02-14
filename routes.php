<?php

use App\Http\Controllers\DashboardController;

$router->get('/', [DashboardController::class, 'index']);
$router->get('/brands/{brand}', [DashboardController::class, 'index']);