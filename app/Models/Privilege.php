<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Privilege extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'role_id',
        'menu_item_id',
        'view',
        'add',
        'edit',
        'delete',
        'other'
    ];

    public function menus()
    {
        return $this->belongsTo(MenuItem::class, 'menu_item_id', 'id');
    }

    public function roles()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
}
