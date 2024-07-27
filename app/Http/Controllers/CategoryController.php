<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryStatusRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function __construct(protected CategoryService $categoryService){}

    public function index()
    {
        $categories = $this->categoryService->getAllCategories();

        return view('category', compact('categories'));
    }


    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();
        $category = $this->categoryService->storeCategory($data['title']);

        return response()->json([
            'message' => 'Successfully created'
        ], 201);
    }


    public function update(UpdateCategoryRequest $request)
    {
        $data = $request->validated();

        $category = $this->categoryService->updateCategory(
            $data['title'],
            $data['id']
        );
        if ($category) {
            return response()->json([
                'message' => 'Successfully updated'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Category not found'],404);
        }

    }

    public function destroy(Request $request)
    {
        $category = $this->categoryService->destroyCategory($request->id);
        if ($category) {
            return response()->json(['message' => 'Successfully deleted']);
        }
      else{
          return response()->json(['message' => 'Category not found']);
      }
    }


    public function updateCategoryStatus(UpdateCategoryStatusRequest $request)
    {
        $data = $request->validated();
        $this->categoryService->updateCategoryStatus($data['id_category'],$data['is_active']);

        return response()->json([
            'message' => 'Successfully updated'
        ]);
    }

}
