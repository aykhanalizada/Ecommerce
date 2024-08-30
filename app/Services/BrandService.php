<?php

namespace App\Services;

use App\Models\Brand;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;

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

        return $brand;

    }

    private function handleImageUpload($brand, $file)
    {
        $fileExtension = $file->extension();
        $fileName = $file->hashName();

        Storage::disk('public')->putFileAs('images/brands', $file, $fileName);


        $media = Media::create([
            'file_name' => $fileName,
            'file_type' => $fileExtension
        ]);
        $brand->fk_id_media = $media->id_media;
        $brand->save();
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
        return $brand;


    }

    private function deleteExistingImage($brand)
    {
        if (!$brand->fk_id_media == null) {
            $filePath = ('images/brands/') . $brand->media->file_name;
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            $brand->media()->update(['is_deleted' => 1, 'is_active' => 0]);
            $brand->fk_id_media = null;
        }
    }

    public function destroyBrand($id)
    {
        $brand = Brand::where('id_brand', $id)->first();


        if ($brand) {
            $brand->is_deleted = 1;
            $brand->is_active = 0;


            $this->deleteExistingImage($brand);

            $brand->save();

            return $brand;
        } else {
            return null;
        }


    }

    public function updateBrandStatus(int $brandId, bool $isActive)
    {
        $brand = Brand::find($brandId);

        $brand->is_active = $isActive;
        $brand->save();

        return $brand;

    }


}
