<?php

use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\SectionConfig;
use App\Mail\NewContactNotification;
use App\Models\Config;
use App\Models\Contact;
use App\Models\SectionOne;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

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

    $provinces = DB::table('province')->pluck('name', 'province_id')->toArray();

    return view('frontend.master', compact('s1', 's2', 's3', 's4', 's5', 's6', 's7', 'config', 'provinces'));
});

Route::get('/get-districts/{province_id}', function ($province_id) {
    $districts = DB::table('district')->where('province_id', $province_id)->get(['district_id as id', 'name']);
    return response()->json($districts);
});

Route::get('/get-wards/{district_id}', function ($district_id) {
    $wards =  DB::table('wards')->where('district_id', $district_id)->get(['wards_id as id', 'name']);
    return response()->json($wards);
});

Route::post('/submit-contact', function (Request $request) {

    $cacheKey = 'contact_' . $request->phone . '_' . md5($request->name);

    if (Cache::has($cacheKey)) {
        return response()->json([
            'message' => 'Bạn chỉ có thể gửi lại sau 5 phút.'
        ], 429);
    }

    $credentials = $request->validate(
        [
            'name'        => 'required|string|max:255',
            'phone'       => 'required|regex:/^0[0-9]{9,10}$/',
            'address'     => 'required|string',
            'province_id' => 'required|integer|exists:province,province_id',
            'district_id' => 'required|integer|exists:district,district_id',
            'ward_id'     => 'required|integer|exists:wards,wards_id',
            'message'     => 'nullable|string',
        ],
        [
            __('request.messages')
        ],
        [
            'name'        => 'Tên',
            'phone'       => 'Số điện thoại',
            'address'     => 'Địa chỉ',
            'province_id' => 'Tỉnh/Thành phố',
            'district_id' => 'Quận/Huyện',
            'ward_id'     => 'Phường/Xã',
            'message'     => 'Lời nhắn',
        ]
    );

    $contact = Contact::where('phone', $credentials['phone'])
        ->where('name', $credentials['name'])->with(['province', 'district', 'ward'])
        ->first();

    if ($contact) {
        // Nếu tồn tại, chỉ cập nhật thời gian
        $contact->touch();
    } else {
        // Nếu chưa có, tạo mới
        $contact = Contact::create($credentials);
    }

    // Gửi email thông báo qua queue
    Mail::to(env('ADMIN_EMAIL'))->queue(new NewContactNotification($contact));

    // Đặt cache chống spam
    Cache::put($cacheKey, true, now()->addMinutes(5));

    return response()->json([
        'message' => 'Đặt hàng thành công!',
    ], 201);
});
