<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    public function getAll()
    {
        return Category::select()
            ->where('is_deleted', 0)
            ->paginate(10);
    }


    public function store(string $title)
    {
        return Category::create([
            'title' => $title
        ]);
    }

    public function update(string $title, int $id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->update([
                'title' => $title
            ]);
            return $category;
        } else {
            return null;
        }
    }


    public function delete(int $id)
    {
        $category = Category::where('id_category', $id)->first();
        if ($category) {
            $category->is_deleted = 1;
            $category->is_active = 0;

            $category->save();
            return $category;
        } else {
            return null;
        }
    }


    public function updateStatus(int $id, bool $isActive)
    {
        $category = Category::where('id_category', $id)->first();
        if ($category) {
            $category->is_active = $isActive;
            $category->save();
            return $category;
        } else {
            return null;
        }

    }


}
