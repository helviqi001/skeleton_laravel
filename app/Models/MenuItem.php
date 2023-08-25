<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'url',
        'sequence',
        'menu_group_id'
    ];

    protected $primaryKey = 'menu_item_id';

    public function menu_group()
    {
        return $this->hasOne(MenuGroup::class, 'menu_group_id', 'menu_group_id');
    }
}
