<?php

use App\Http\Controllers\DashboardController;

$router->get('/', [DashboardController::class, 'index']);