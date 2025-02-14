<?php

use App\Http\Controllers\DashboardController;

//$router->get('/', [DashboardController::class, 'index']);
$router->get('/brands/{id}', [DashboardController::class, 'index']);