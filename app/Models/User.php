<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $table = 'user';

    protected $primaryKey = 'id_user';
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'is_admin',
        'remember_token'
    ];

    public function media()
    {
        return $this->belongsTo(Media::class, 'fk_id_media', 'id_media');
    }

}
