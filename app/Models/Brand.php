<?php

namespace App\Models;

use App\Observers\BrandObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([BrandObserver::class])]
class Brand extends Model
{
    use HasFactory;

    protected $table = 'brand';

    protected $primaryKey = 'id_brand';

//    protected $foreignKey = "fk_id_media";
    protected $fillable = [
        'title',
        'is_active',
        'is_deleted',
        'created_by',
        'updated_by'
    ];

    public function media(){
        return $this->belongsTo(Media::class,'fk_id_media',"id_media");
    }

    public function products(){
        return $this->hasMany(Product::class,'fk_id_brand',"id_brand");
    }
}
