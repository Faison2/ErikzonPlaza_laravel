<?php
// filepath: app\Http\Controllers\Admin\SellerController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function index()
    {
        $sellers = Seller::all();
        return view('admin.sellers.index', compact('sellers'));
    }

    public function create()
    {
        return view('admin.sellers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:sellers',
        ]);

        Seller::create($request->all());
        return redirect()->route('admin.sellers.index')->with('success', 'Seller created successfully!');
    }

    public function edit(Seller $seller)
    {
        return view('admin.sellers.edit', compact('seller'));
    }

    public function update(Request $request, Seller $seller)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:sellers,email,' . $seller->id,
        ]);

        $seller->update($request->all());
        return redirect()->route('admin.sellers.index')->with('success', 'Seller updated successfully!');
    }

    public function destroy(Seller $seller)
    {
        $seller->delete();
        return redirect()->route('admin.sellers.index')->with('success', 'Seller deleted successfully!');
    }
}