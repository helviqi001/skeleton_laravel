<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'created_by',
        'updated_by'
    ];

    public function privileges()
    {
        return $this->hasMany(Privilege::class, 'role_id', 'id');
    }
}
