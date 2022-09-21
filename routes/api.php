<?php

use App\Http\Controllers\api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('compaignList', [ApiController::class, 'compaignList']);
Route::post('/add_compaign', [ApiController::class, 'add_compaign']);
Route::post('/edit_compaign', [ApiController::class, 'edit_compaign']);
Route::get('/delete_compaign/{id}', [ApiController::class, 'delete_compaign']);

