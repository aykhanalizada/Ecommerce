<?php

namespace App\Services;


use App\Models\Brand;
use App\Models\Category;
use App\Models\Media;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;


class ProductService
{
    public function getAllProducts()
    {
        $products = Product::notDeleted()
            ->with(['categories', 'relatedProducts'])
            ->paginate(5);

        $allProducts = Product::all(); // select?

        $categories = Cache::remember('categories', 3600, function () {
            return Category::all();
        });


        $brands = Cache::remember('brands', 3600, function () {
            return Brand::all();
        });

        return [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'allProducts' => $allProducts
        ];
    }

    public function storeProduct($data)
    {
        $title = $data['title'];
        $price = $data['price'];
        $category = $data['category'];
        $brand = $data['brand'];
        $description = $data['description'];
        $files = $data['productImages'];
        $mainImageName = $data['mainImageName'];
        $relatedProducts = $data['relatedProducts'] ?? null;

        $brandExists = Brand::find($brand);
        if (!$brandExists) {
            throw new \Exception("Brand ID $brand does not exist ");
        }

        $categoryExists = Brand::find($category);
        if (!$categoryExists) {
            throw new \Exception("Category ID $category does not exist ");
        }

        $mainImageExists = false;

        foreach ($files as $file) {
            if ($file->getClientOriginalName() == $mainImageName) {
                $mainImageExists = true;
                break;
            }

        }
        if ($mainImageName && !$mainImageExists) {
            throw new \Exception("The selected main image does not exist in the uploaded files.");
        }


        $newProduct = DB::transaction(function () use ($title, $price, $category, $brand, $description, $files, $mainImageName, $relatedProducts) {
            $product = Product::create([
                'title' => $title,
                'price' => $price,
                'fk_id_brand' => $brand,
                'description' => $description
            ]);
            $product->categories()->attach($category);

            foreach ($files as $file) {
                $isMain = $file->getClientOriginalName() == $mainImageName ? 1 : 0;
                $this->handleImageUpload($product, $file, $isMain);

            }

            if ($relatedProducts) {
                $product->relatedProducts()->attach($relatedProducts);

            }
            return $product;

        });
        return $newProduct;

    }

    private function handleImageUpload($product, $file, $isMain)
    {
        $fileExtension = $file->extension();
        $fileName = $file->hashName();

        $media = Media::create([
            'file_name' => $fileName,
            'file_type' => $fileExtension
        ]);
        $product->images()->attach($media->id_media, ['is_main' => $isMain]);
        $product->save();


        $path = public_path('images/products');
        $file->move($path, $fileName);
    }

    public function updateProduct(
        int    $id,
        string $title,
        float  $price,
        int    $category,
        int    $brand,
        string $description,
               $files = null,
        string $mainImageName = null,
               $relatedProducts = null
    )
    {
        $product = Product::find($id);

        if (!$product) {
            return null;
        }

        $product->title = $title;
        $product->price = $price;
        $product->fk_id_brand = $brand;
        $product->description = $description;

        $product->categories()->sync($category);


        if ($files) {

            $this->deleteExistingImage($product);


            foreach ($files as $file) {
                $isMain = $file->getClientOriginalName() == $mainImageName ? 1 : 0;

                $this->handleImageUpload($product, $file, $isMain);

            }

        } else {
            $product->save();
        }


        if ($relatedProducts) {
            $product->relatedProducts()->sync($relatedProducts);

        }

        $product->save();
        return $product;


    }

    private function deleteExistingImage($product)
    {
        foreach ($product->images as $image) {

            $filePath = ('images/products/') . $image->file_name;
            if (file_exists($filePath)) {
                unlink(public_path('images/products/') . $image->file_name);

                $product->images()->detach();
            }
        }
    }

    public function destroyProduct($id)
    {
        $product = Product::where('id_product', $id)->first();

        if ($product) {
            $product->is_deleted = 1;
            $product->is_active = 0;


            $product->save();

            return $product;
        } else {
            return null;
        }


    }

    public function updateProductStatus(int $productId, bool $isActive)
    {
        $product = Product::find($productId);

        if (!$product) {
            throw new \Exception("Product with ID {$productId} not found.");
        }
        $product->is_active = $isActive;
        $product->save();

        return $product;

    }

    public function searchProduct($query)
    {
        $products = Product::notDeleted()
            ->where('title', 'like', '%' . $query . '%')
            ->with(['categories', 'relatedProducts'])
            ->paginate(5)->withQueryString();

        $allProducts = Product::all();
        $categories = Category::all();
        $brands = Brand::all();


        return [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'allProducts' => $allProducts
        ];

    }

    public function filterProducts($category, $brand, $status)
    {

        /*        $products = DB::table('product')
                    ->join('product_category', 'product.id_product',  '=', 'product_category.fk_id_product')
                    ->join('category', 'product_category.fk_id_category', '=', 'category.id_category')
                    ->where('product_category.fk_id_category','=',$category)
                    ->select('product.*', 'category.title as category_title')
                    ->get();
        */


        $products = Product::query();
        if ($category) {
            $products->whereHas('categories', function ($query) use ($category) {
                $query->where('id_category', $category);
            });
        }

        if ($brand) {
            $products->whereHas('brand', function ($query) use ($brand) {
                $query->where('id_brand', $brand);
            });
        }

        if ($status !== null) {
            $products->where('is_active', $status);
        }

        $products = $products->with(['categories', 'brand'])->paginate(5)->withQueryString();


        $allProducts = Product::all();
        $categories = Category::all();
        $brands = Brand::all();


        return [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'allProducts' => $allProducts
        ];

    }


}
