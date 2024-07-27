<?php

namespace App\Models;

use App\Observers\CategoryObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([CategoryObserver::class])]
class Category extends Model
{
    use HasFactory;

    protected $table = 'category';
    protected $primaryKey = "id_category";
    protected $fillable = [
        'title',
        'is_active',
        'is_deleted',
        'created_by',
        'updated_by',
        ];

    public function products(){
        return $this->belongsToMany(Product::class,'product_category','fk_id_category','fk_id_product');
    }

}
