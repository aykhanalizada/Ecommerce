<?php

namespace App\Services;

use App\Models\Brand;
use App\Models\Media;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BrandService
{
    public function getAllBrands()
    {
        return Brand::with('media')
            ->where('is_deleted', 0)
            ->paginate(5);
    }

    public function storeBrand(string $title, $file)
    {
        $brand = Brand::create([
            'title' => $title
        ]);

        if ($file) {
            $this->handleImageUpload($brand, $file);
        }
//        Cache::forget('brands');

        return $brand;

    }

    public function updateBrand(string $title, int $id, $file)
    {
        $brand = Brand::find($id);

        if (!$brand) {
            return null;
        }

        $brand->title = $title;

        if ($file) {
            $this->deleteExistingImage($brand);
            $this->handleImageUpload($brand, $file);

        } else {
            $brand->save();
        }
//        Cache::forget('brands');
        return $brand;


    }


    public function destroyBrand($id)
    {
        $brand = Brand::where('id_brand', $id)->first();


        if ($brand) {
            $brand->is_deleted = 1;
            $brand->is_active = 0;


            $this->deleteExistingImage($brand);

            $brand->save();
//            Cache::forget('brands');

            return $brand;
        } else {
            return null;
        }


    }


    public function updateBrandStatus($request)
    {
        $request->validate([
            'is_active' => 'required|boolean',
            "id_brand" => 'required'
        ]);

        $brand = Brand::find($request->id_brand);

        $brand->is_active = $request->is_active;
        $brand->save();

        Cache::forget('brands');
        return $brand;

    }


    private function handleImageUpload($brand, $file)
    {
        $fileExtension = $file->extension();
        $fileName = $file->hashName();

        $path = public_path('images/brands');
        $file->move($path, $fileName);

        $media = Media::create([
            'file_name' => $fileName,
            'file_type' => $fileExtension
        ]);
        $brand->fk_id_media = $media->id_media;
        $brand->save();
    }


    private function deleteExistingImage($brand)
    {
        if (!$brand->fk_id_media == null) {
            $filePath = ('images/brands/') . $brand->media->file_name;
            if (file_exists($filePath)) {
                unlink(public_path('images/brands/') . $brand->media->file_name);
            }
            $brand->media()->update(['is_deleted' => 1, 'is_active' => 0]);
            $brand->fk_id_media = null;
        }
    }


}
