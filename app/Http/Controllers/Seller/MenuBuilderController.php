<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class MenuBuilderController extends Controller
{
    public function index(): View
    {
        return view('admin.menu-builder.index');
    }
}
