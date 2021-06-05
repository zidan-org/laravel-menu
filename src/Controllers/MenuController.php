<?php

namespace NguyenHuy\Menu\Controllers;

use NguyenHuy\Menu\Facades\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use NguyenHuy\Menu\Models\Menus;
use NguyenHuy\Menu\Models\MenuItems;

class MenuController extends Controller
{
    public function createNewMenu(Request $request)
    {
        $menu = new Menus();
        $menu->name = $request->input('menuname');
        $menu->save();
        return response()->json([
            'resp' => $menu->id
        ], 200);
    }

    public function deleteItemMenu(Request $request)
    {
        $menuitem = MenuItems::findOrFail($request->input('id'));
        $menuitem->delete();
        return response()->json([
            'resp' => 1
        ], 200);
    }

    public function deleteMenug(Request $request)
    {
        $menudelete = Menus::findOrFail($request->input('id'));
        $menudelete->delete();

        return response()->json([
            'resp' => 'You delete this item'
        ], 200);
    }

    public function updateItem(Request $request)
    {
        $arraydata = $request->input('arraydata');
        if (is_array($arraydata)) {
            foreach ($arraydata as $value) {
                $menuitem = MenuItems::findOrFail($value['id']);
                $menuitem->label = $value['label'];
                $menuitem->link = $value['link'];
                $menuitem->class = $value['class'];
                $menuitem->icon = $value['icon'];
                $menuitem->target = $value['target'];
                if (config('menu.use_roles')) {
                    $menuitem->role_id = $value['role_id'] ? $value['role_id'] : 0;
                }
                $menuitem->save();
            }
        } else {
            $menuitem = MenuItems::findOrFail($request->input('id'));
            $menuitem->label = $request->input('label');
            $menuitem->link = $request->input('url');
            $menuitem->class = $request->input('clases');
            $menuitem->icon = $request->input('icon');
            $menuitem->target = $request->input('target');
            if (config('menu.use_roles')) {
                $menuitem->role_id = $request->input('role_id') ? $request->input('role_id') : 0;
            }
            $menuitem->save();
        }
        return response()->json([
            'resp' => 1
        ], 200);
    }

    public function addCustomMenu(Request $request)
    {
        $menuitem = new MenuItems();
        $menuitem->label = $request->input('labelmenu');
        $menuitem->link = $request->input('linkmenu');
        $menuitem->icon = $request->input('iconmenu');
        if (config('menu.use_roles')) {
            $menuitem->role_id = $request->input('rolemenu') ? $request->input('rolemenu')  : 0;
        }
        $menuitem->menu = $request->input('idmenu');
        $menuitem->sort = MenuItems::getNextSortRoot($request->input('idmenu'));
        $menuitem->save();
        return response()->json([
            'resp' => 1
        ], 200);
    }

    public function generateMenuControl(Request $request)
    {
        $menu = Menus::findOrFail($request->input('idMenu'));
        $menu->name = $request->input('menuName');
        $menu->save();
        if (is_array($request->input('data'))) {
            foreach ($request->input('data') as $key => $value) {
                $menuitem = MenuItems::findOrFail($value['id']);
                $menuitem->parent = $value['parent_id'] ?? 0;
                $menuitem->sort = $key;
                $menuitem->depth = $value['depth'] == 0 ? 0 : $value['depth'] - 1;
                if (config('menu.use_roles')) {
                    $menuitem->role_id = $request->input('role_id');
                }
                $menuitem->save();
            }
        }
        return response()->json([
            'resp' => 1
        ], 200);
    }
}
