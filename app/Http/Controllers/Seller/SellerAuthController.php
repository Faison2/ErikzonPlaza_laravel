<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class AdminAuthController extends Controller
{
    public function index(): View
    {
        return view('seller.auth.login');
    }

    public function forgetPassword(): View
    {
        return view('seller.auth.forget-password');
    }
}
