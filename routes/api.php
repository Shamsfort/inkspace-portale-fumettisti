<?php

use App\Http\Controllers\Api\AuthenticatedUserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', AuthenticatedUserController::class);

