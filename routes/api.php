<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ContactController;

Route::get('/contacts', [ContactController::class, 'index']);