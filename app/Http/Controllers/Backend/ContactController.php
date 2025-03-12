<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::query()->with('province', 'district', 'ward')->latest()->get();

        return view('backend.contact.contact', compact('contacts'));
    }


    public function changeEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $envPath = base_path('.env');
        if (!File::exists($envPath)) {
            return response()->json(['message' => '.env file not found'], 500);
        }

        $envContent = file_get_contents($envPath);
        $envContent = preg_replace('/^ADMIN_EMAIL=.*/m', 'ADMIN_EMAIL=' . $request->email, $envContent);
        file_put_contents($envPath, $envContent);

        Artisan::call('config:clear');

        return handleResponse('Cập nhật email thành công!', 200);
    }
}
