<?php

namespace Zidan\Menu\Models;

use Illuminate\Database\Eloquent\Model;

class Menus extends Model
{
    use Traits\QueryCacheTrait;

    protected $table = 'menus';

    public function __construct(array $attributes = [])
    {
        //parent::construct( $attributes );
        $this->table = config('menu.table_prefix') . config('menu.table_name_menus');
    }

    public static function byName($name)
    {
        return self::where('name', '=', $name)->first();
    }

    public function items()
    {
        return $this->hasMany('Zidan\Menu\Models\MenuItems', 'menu')
            ->with('child')
            ->where('parent', 0)
            ->orderBy('sort', 'ASC');
    }
    public function itemAndChilds()
    {
        return $this->hasMany('Zidan\Menu\Models\MenuItems', 'menu')
            ->with('child')
            ->orderBy('sort', 'ASC');
    }
}
