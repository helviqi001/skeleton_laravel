<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuGroup extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'sequence',
        'icon',
        'platform',
        'status'
    ];

    public function menu_item()
    {
        return $this->hasMany(MenuItem::class, 'menu_group_id', 'id');
    }
}
