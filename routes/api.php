<?php

use App\Http\Controllers\EntryController;
use App\Http\Controllers\UserController;
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
// endpoint: /api/users
Route::controller(UserController::class)
    ->prefix('users')
    ->group(function ($route) {
        $route->get('', 'all');
    });

// endpoint: /api/entries
Route::controller(Entrycontroller::class)
    ->prefix('entries')
    ->group(function (\Illuminate\Routing\Router $route) {
//        var_dump($route->);
//        die('here');
        $route->post('/', 'insert');
        $route->get('', 'list');
    });
