<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    
    Route::get('send-email', [SendEmailController::class, 'index']);

    
});
