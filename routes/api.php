<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, PATCH, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\SubMenuController;

// Route::apiResource('menus', MenuController::class);

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


// List all menus
Route::get('menus', [MenuController::class, 'index']);

// Create a new menu
Route::get(
    'add_menu/{name}/{gastronomy}/{price_per_person}/{min_people}/{description}',
    [MenuController::class, 'add_menu']
);


// id: number;
// gastronomy: number;
// name: string;
// price_per_person: number;
// min_people: number;
// description: string;

// Get a menu by ID
Route::get('get_menus/{id}', [MenuController::class, 'getMenuById']);

// Update a menu by ID
Route::get('update_menus/{id}', [MenuController::class, 'update']);

// Delete a menu by ID
Route::get('delete_menu/{id}', [MenuController::class, 'destroy']);



Route::prefix('submenus')->group(function () {
    Route::get('/', [SubMenuController::class, 'getAllSubmenus']);
    // Route::get('/{id}', [SubMenuController::class, 'getSubmenu']);
    Route::post('/add_sous_menu', [SubMenuController::class, 'createSubmenu']);
    // Route::put('/{id}', [SubMenuController::class, 'updateSubmenu']);
    Route::delete('delete_sub_menu/{id}', [SubMenuController::class, 'deleteSubmenu']);
});
Route::post('/generatesignature', [SubMenuController::class, 'generateSignature']);
// /{name}/{category}/{price}/{description}/{gastronomy}/{image_path}

// Weekly Items (Menu de la semaine)
Route::prefix('weekly-items')->group(function () {
    Route::get('/', [SubMenuController::class, 'getAllWeeklyItems']);
    Route::post('/create-weekly-item', [SubMenuController::class, 'createWeeklyItem']);
    Route::put('/update-weekly-item/{id}', [SubMenuController::class, 'updateWeeklyItem']);
    Route::delete('/delete-weekly-item/{id}', [SubMenuController::class, 'deleteWeeklyItem']);
    Route::post('/delete-all-weekly-items', [SubMenuController::class, 'deleteAllWeeklyItems']);
});

Route::post('add_week_pdf', [MenuController::class, 'addWeekPdf']);
Route::get('week_pdfs', [MenuController::class, 'getWeekPdfs']);

// ngrok http --url=mingback.ngrok.app 80