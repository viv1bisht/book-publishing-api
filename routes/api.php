<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
 use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookController;
  use App\Http\Controllers\Api\ChapterController;
  use App\Http\Controllers\Api\PageController;

 Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('jwt')->group(function () {

    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/books', [BookController::class, 'store']);
    Route::get('/books', [BookController::class, 'index']);
    Route::put('/books/{id}', [BookController::class, 'update']);
    Route::delete('/books/{id}', [BookController::class, 'destroy']);
    Route::post('/books/{id}/submit', [BookController::class, 'submit']);
    Route::post('/books/{id}/approve', [BookController::class, 'approve']);
    Route::post('/books/{id}/reject', [BookController::class, 'reject']);
    Route::post('/books/{id}/publish', [BookController::class, 'publish']);

    Route::post('/chapters', [ChapterController::class,'store']);

Route::get('/books/{book_id}/chapters', [ChapterController::class,'index']);

Route::post('/pages', [PageController::class,'store']);

Route::get('/chapters/{chapter_id}/pages', [PageController::class,'index']);

Route::post('/books/{id}/reject', [BookController::class,'reject']);
Route::post('/books/{id}/publish', [BookController::class,'publish']);
Route::post('/books/{id}/upload', [BookController::class, 'upload']);

Route::get('/dashboard', [AuthController::class, 'dashboard']);

Route::get('/books/{id}', [BookController::class, 'show']);

Route::post('/logout', [AuthController::class, 'logout']);

Route::put('/chapters/{id}', [ChapterController::class, 'update']);

Route::delete('/chapters/{id}', [ChapterController::class, 'destroy']);


Route::put('/pages/{id}', [PageController::class, 'update']);

Route::delete('/pages/{id}', [PageController::class, 'destroy']);
});

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  //  return $request->user();
//});

