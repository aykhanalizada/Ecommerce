<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Media extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_media';

    protected $fillable = [
        'file_name',
        'file_type',
        'is_active',
        'is_deleted',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at'
    ];

    public function brand(){
        return $this->hasOne(Brand::class,'fk_id_media','id_media');
    }




}
