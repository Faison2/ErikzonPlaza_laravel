<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TramsAndCondition;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TramsAndConditionController extends Controller
{
    public function index(): View
    {
        $tramsAndCondition = TramsAndCondition::first();

        return view('admin.trams-and-condition.index', compact('tramsAndCondition'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'content' => ['required'],
        ]);

        TramsAndCondition::updateOrCreate(
            ['id' => 1],
            [
                'content' => $request->content,
            ]
        );
        toastr()->success('Updated Successfully');

        return redirect()->back();
    }
}
