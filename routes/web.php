<?php

use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\SectionConfig;
use App\Models\Config;
use App\Models\SectionOne;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('admin')->name('admin.')->group(function () {

    Route::prefix('auth')->middleware('guest')->controller(AuthController::class)->name('auth.')->group(function () {
        Route::get('login', 'login')->name('login');
        Route::post('login', 'authenticate');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/', fn() => view('backend.dashboard'))->name('dashboard');
        Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');

        Route::get('section/{number}', [SectionConfig::class, 'switchView'])->name('section.config.view');
        Route::post('section/{number}', [SectionConfig::class, 'switchPost'])->name('section.config.post');
    });
});

Route::get('/', function () {
    $numbers = ["One", "Two", "Three", "Four", "Five", "Six"];

    foreach ($numbers as $key => $num) {
        $modelClass = "App\\Models\\Section{$num}";

        if (class_exists($modelClass)) {
            ${"s" . ($key + 1)} = $modelClass::query()->firstOrCreate([]);
        }
    }

    $s7 = App\Models\SectionSeven::all()->map(function ($item) {
        return [
            'icon' => $item->icon,
            'title' => $item->title,
            'content' => $item->content,
        ];
    })->toArray();

    $config = Config::query()->firstOrCreate();

    return view('frontend.master', compact('s1', 's2', 's3', 's4', 's5', 's6', 's7', 'config'));
});
