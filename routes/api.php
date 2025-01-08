<?php

use App\Http\Controllers\Api\V1\TruePeopleSearchApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')
    ->group(function () {
        Route::get('truepeoplesearch/results', [TruePeopleSearchApiController::class, 'index'])
            ->name('truepeoplesearch.index');

        Route::get('truepeoplesearch/results/{profileId}', [TruePeopleSearchApiController::class, 'show'])
            ->name('truepeoplesearch.show');
    });
