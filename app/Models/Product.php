<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';

    protected $primaryKey = 'id_product';

    protected $fillable = ['title', 'price', 'fk_id_brand', 'description'];


    public function scopeNotDeleted($query)
    {
        return $query->where('is_deleted', 0);
    }


    public function brand()
    {
        return $this->belongsTo(Brand::class, 'fk_id_brand', 'id_brand');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category', 'fk_id_product', 'fk_id_category');
    }

    public function images()
    {
        return $this->belongsToMany(Media::class, 'product_media', 'fk_id_product', 'fk_id_media')
            ->withPivot('is_main');
    }

    public function relatedProducts()
    {
        return $this->belongsToMany(Product::class, 'related_products', 'fk_id_product', 'fk_id_related');
    }


}
