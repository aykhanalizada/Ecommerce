<?php

namespace App\Http\Controllers;

use App\Http\Requests\Brand\StoreBrandRequest;
use App\Http\Requests\Brand\UpdateBrandRequest;
use App\Http\Requests\Brand\UpdateBrandStatusRequest;
use App\Services\BrandService;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function __construct(protected BrandService $brandService)
    {
    }

    public function index()
    {
        $brands = $this->brandService->getAllBrands();
        return view('brand', compact('brands'));
    }

    public function store(StoreBrandRequest $request)
    {
        $data = $request->validated();

        $brand = $this->brandService->storeBrand($data['title'], $data['file'] ?? null);
        return response()->json([
            'message' => 'Successfully created'
        ], 201);
    }


    public function update(UpdateBrandRequest $request)
    {
        $data = $request->validated();

        $brand = $this->brandService->updateBrand(
            $data['title'],
            $data['id'],
            $data['file'] ?? null
        );
        if ($brand) {
            return response()->json([
                'message' => 'Successfully updated'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Brand not found'], 404);
        }

    }

    public function destroy(Request $request)
    {
        $brand = $this->brandService->destroyBrand($request->id);
        if ($brand) {
            return response()->json(['message' => 'Successfully deleted']);
        } else {
            return response()->json(['message' => 'Brand not found']);
        }
    }

    public function updateBrandStatus(UpdateBrandStatusRequest $request)
    {
        $data = $request->validated();
        $this->brandService->updateBrandStatus($data['id_brand'], $data['is_active']);

        return response()->json([
            'message' => 'Successfully updated'
        ]);
    }


}
