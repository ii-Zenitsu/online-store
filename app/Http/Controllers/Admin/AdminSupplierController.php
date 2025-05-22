<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class AdminSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $viewData = [];
        $viewData["title"] = "Admin Page - Suppliers - Online Store";
        $viewData["suppliers"] = Supplier::all();
        return view('admin.supplier.index')->with("viewData", $viewData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'raison_sociale' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'tele' => "required|string|regex:/^\+?[0-9]{10,15}$/|unique:suppliers,tele",
            'email' => 'required|email|unique:suppliers,email',
            'description' => 'nullable|string|max:1000',
        ]);

        $supplier = new Supplier();
        $supplier->raison_sociale = $request->input('raison_sociale');
        $supplier->adresse = $request->input('adresse');
        $supplier->tele = $request->input('tele');
        $supplier->email = $request->input('email');
        $supplier->description = $request->input('description');
        $supplier->save();

        return redirect()->route('admin.supplier.index')->with('success', 'Supplier created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $viewData = [];
        $viewData["title"] = "Admin Page - Edit Supllier - Online Store";
        $viewData["supplier"] = Supplier::findOrFail($id);
        return view('admin.supplier.edit')->with("viewData", $viewData);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'raison_sociale' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'tele' => "required|string|regex:/^\+?[0-9]{10,15}$/|unique:suppliers,tele,".$id,
            'email' => 'required|email|unique:suppliers,email,' . $id,
            'description' => 'nullable|string|max:1000',
        ]);

        $supplier = Supplier::findOrFail($id);
        $supplier->raison_sociale = $request->input('raison_sociale');
        $supplier->adresse = $request->input('adresse');
        $supplier->tele = $request->input('tele');
        $supplier->email = $request->input('email');
        $supplier->description = $request->input('description');
        $supplier->save();

        return redirect()->route('admin.supplier.index')->with('success', 'Supplier updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return redirect()->route('admin.supplier.index')->with('success', 'Supplier deleted successfully.');
    }
}