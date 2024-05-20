<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Products;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    private const VALIDATION_RULES = [
        'productName' => 'required|string|min:3|max:155',
        'manufacturer' => 'required|string|min:3|max:155',
        'registryNumber' => 'required|string|min:10|max:25',
        'quantity' => 'required|numeric',
        'price' => 'required',
        'defensives' => 'required|string|min:3|max:155',
        'chemicalGroup' => 'required|string|min:3|max:155',
        'document_id' => 'array',
    ];

    public function index()
    {
        $products = Products::all();

        foreach ($products as $product) {
            $arrayCategory = json_decode($product->category);

            $documentName = [];

            foreach ($arrayCategory as $category) {
                $documentName[] = Document::findOrFail($category)->name;
            }

            $product->documentName = $documentName;
        }

        return view('pages.products.index', ['products' => $products]);
    }

    public function create()
    {
        $product = new Products();
        return view('pages.products.create', compact('product'));
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate(self::VALIDATION_RULES);

        $description = [
            'defensives' => $request->defensives,
            'chemicalGroup' => $request->chemicalGroup,
            'activeIngredient' => $request->activeIngredient,
            'toxicologicalClass' => $request->toxicologicalClass,
            'percentage' => $request->percentage,
        ];

        $product = new Products();

        $product->name = $request->productName;
        $product->manufacturer = $request->manufacturer;
        $product->description = json_encode($description);
        $product->registryNumber = $request->registryNumber;
        $product->quantity = $request->quantity;
        $product->price = str_replace(',', '.', $request->price);
        $product->category = json_encode($request->document_id);

        $isSaved = $product->save();

        if (!$isSaved) {
            return response()->json(['error' => 'Error saving product'], 500);
        }

        return response()->json(['success' => 'Product saved successfully'], 200);
    }

    public function edit(Products $product)
    {
        $categories = [];

        foreach (json_decode($product->category) as $category) {
            $categories[] = Document::findOrFail($category);
        }

        return view('pages.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request)
    {
        $request->validate(self::VALIDATION_RULES);

        $product = Products::findOrFail($request->productId);

        $description = [
            'defensives' => $request->defensives,
            'chemicalGroup' => $request->chemicalGroup,
            'activeIngredient' => $request->activeIngredient,
            'toxicologicalClass' => $request->toxicologicalClass,
        ];

        $product->name = $request->productName;
        $product->manufacturer = $request->manufacturer;
        $product->description = json_encode($description);
        $product->registryNumber = $request->registryNumber;
        $product->quantity = $request->quantity;
        $product->price = str_replace(',', '.', $request->price);

        $isSaved = $product->save();

        if (!$isSaved) {
            return response()->json(['error' => 'Error updating product'], 500);
        }

        return response()->json(['success' => 'Product updated successfully'], 200);
    }

    public function destroy(Products $product)
    {
        $isDeleted = $product->delete();

        if (!$isDeleted) {
            return response()->json(['error' => 'Error deleting product'], 500);
        }

        return response()->json(['success' => 'Product deleted successfully'], 200);
    }
}
