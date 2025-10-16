<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:api')->get('/user', function (\Illuminate\Http\Request $request) {
    $user = $request->user();
    return [
        'id'    => $user->id,
        'name'  => $user->name,
        'email' => $user->email,
        'roles' => $user->roles->pluck('name'),  // Par ex. si relation roles ou trait HasRoles
    ];
});
