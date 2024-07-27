<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(protected ProductService $productService)
    {
    }

    public function index()
    {
        $data = $this->productService->getAllProducts();

        return view('product', [
            "products" => $data['products'],
            "categories" => $data['categories'],
            "brands" => $data['brands'],
            "allProducts" => $data['allProducts']
        ]);
    }

    public function store(StoreProductRequest $request)
    {

        $data = $request->validated();

        $product = $this->productService->storeProduct($data);
        return response()->json([
            'message' => 'Successfully created'
        ], 201);
    }


    public function update(UpdateProductRequest $request)
    {
        $data = $request->validated();

        $product = $this->productService->updateProduct(
            $data['id'],
            $data['title'],
            $data['price'],
            $data['category'],
            $data['brand'],
            $data['description'],
            $data['productImages'] ?? null,
            $data['mainImageName'] ?? null,
            $data['relatedProducts'] ?? null

        );
        if ($product) {
            return response()->json([
                'message' => 'Successfully updated'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Product not found'], 404);
        }

    }

    public function destroy(Request $request)
    {
        $product = $this->productService->destroyProduct($request->id);
        if ($product) {
            return response()->json(['message' => 'Successfully deleted']);
        } else {
            return response()->json(['message' => 'Product not found']);
        }
    }

    public function updateProductStatus(Request $request)
    {
        $this->productService->updateProductStatus($request);

        return response()->json([
            'message' => 'Successfully updated'
        ]);
    }

    public function search(Request $request)
    {
        $data = $this->productService->searchProduct($request->input('query'));

        return view('product', [
            'products' => $data['products'],
            'categories' => $data['categories'],
            'brands' => $data['brands'],
            'allProducts' => $data['allProducts']

        ]);
    }

    public function filter(Request $request)
    {
        $category = $request->category;
        $brand = $request->brand;
        $status = $request->status;

        $data = $this->productService->filterProducts($category, $brand, $status);

        return view('product', [
            'products' => $data['products'],
            'categories' => $data['categories'],
            'brands' => $data['brands'],
            'allProducts' => $data['allProducts']

        ]);
    }


}
