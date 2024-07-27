<?php

namespace App\Services;

use App\Http\Requests\Category\UpdateCategoryStatusRequest;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryService
{

    public function __construct(protected CategoryRepository $categoryRepository)
    {
    }

    public function getAllCategories()
    {
        return $this->categoryRepository->getAll();

    }

    public function storeCategory(string $title)
    {
        return $this->categoryRepository->store($title);
    }

    public function updateCategory(string $title, int $id)
    {
        return $this->categoryRepository->update($title, $id);
    }

    public function destroyCategory($id)
    {
        return $this->categoryRepository->delete($id);

    }


    public function updateCategoryStatus(int $id, bool $is_active)
    {
        $this->categoryRepository->updateStatus($id, $is_active);
    }


}
