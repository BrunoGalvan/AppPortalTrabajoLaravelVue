<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorksplaceController;

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

Route::middleware('api')->group(function () {
    Route::get('/worksplaces', [WorksplaceController::class, 'ListWorksplace'])->name('worksplaces.list');
    Route::get('/worksplaces/candidate/{u_id}', [WorksplaceController::class, 'ListWorksplacePost'])->name('worksplaces_post.list');
    Route::get('/candidates_has_worksplaces/{id}', [WorksplaceController::class, 'CandidatesWorksplace'])->name('candidates_worksplace.list');
    Route::get('/workday/options', [WorksplaceController::class, 'OptionsWorkday'])->name('workday.options');
    Route::get('/checkpost/{u_id}/{w_id}', [WorksplaceController::class, 'CheckPostWorksplace'])->name('check.post');
    Route::get('/worksplace/candidate/download/{f_name}', [WorksplaceController::class, 'DowloadFileCVPost'])->name('dowload.cv');
    Route::post('/worksplace/create', [WorksplaceController::class, 'CreateWorksplace'])->name('worksplace.create');
    Route::post('/worksplace/post/create', [WorksplaceController::class, 'CreatePostWorksplace'])->name('worksplace_post.create');
    Route::put('/worksplace/update/{id}', [WorksplaceController::class, 'UpdateWorksplace'])->name('worksplace.update');
    Route::delete('/worksplace/destroy/{id}', [WorksplaceController::class, 'DestroyWorksplace'])->name('worksplace.destroy');
});
