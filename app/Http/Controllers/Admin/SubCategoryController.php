<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SubCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SubCategoryCreateRequest;
use App\Http\Requests\Admin\SubCategoryUpdateRequest;
use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Str;

class SubCategoryController extends Controller
{
    public function index(SubCategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.product.subcategory.index');
    }

    public function create(): View
    {
        $categories = Category::pluck('name', 'id');
        return view('admin.product.subcategory.create', compact('categories'));
    }

    public function store(SubCategoryCreateRequest $request): RedirectResponse
    {
        $subcategory = new SubCategory();
        $subcategory->category_id = $request->category_id;
        $subcategory->name = $request->name;
        $subcategory->slug = Str::slug($request->name);
        $subcategory->show_at_home = $request->show_at_home ? 1 : 0;
        $subcategory->status = $request->status;
        $subcategory->save();

        toastr()->success('Created Successfully');
        return to_route('admin.subcategory.index');
    }

    public function edit(string $id): View
    {
        $subcategory = SubCategory::findOrFail($id);
        $categories = Category::pluck('name', 'id');
        return view('admin.product.subcategory.edit', compact('subcategory', 'categories'));
    }

    public function update(SubCategoryUpdateRequest $request, string $id): RedirectResponse
    {
        $subcategory = SubCategory::findOrFail($id);
        $subcategory->category_id = $request->category_id;
        $subcategory->name = $request->name;
        $subcategory->slug = Str::slug($request->name);
        $subcategory->status = $request->status;
        $subcategory->save();

        toastr()->success('Updated Successfully');
        return to_route('admin.subcategory.index');
    }

    public function destroy(string $id)
    {
        try {
            SubCategory::findOrFail($id)->delete();
            return response(['status' => 'success', 'message' => 'Deleted Successfully!']);
        } catch (\Exception $e) {
            return response(['status' => 'error', 'message' => 'Something went wrong!']);
        }
    }
}
