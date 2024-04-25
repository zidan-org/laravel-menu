# Laravel Drag and Drop menu
[![Latest Stable Version](https://poser.pugx.org/nguyendachuy/laravel-menu/v)](//packagist.org/packages/nguyendachuy/laravel-menu) [![Total Downloads](https://poser.pugx.org/nguyendachuy/laravel-menu/downloads)](//packagist.org/packages/nguyendachuy/laravel-menu) [![Latest Unstable Version](https://poser.pugx.org/nguyendachuy/laravel-menu/v/unstable)](//packagist.org/packages/nguyendachuy/laravel-menu) [![License](https://poser.pugx.org/nguyendachuy/laravel-menu/license)](//packagist.org/packages/nguyendachuy/laravel-menu)


![Laravel drag and drop menu](https://raw.githubusercontent.com/nguyendachuy/laravel-menu/master/screenshot.png)

### Installation

1. Run

```php
composer require nguyendachuy/laravel-menu
```
2. Run publish

```php
php artisan vendor:publish --provider="NguyenHuy\Menu\Providers\MenuServiceProvider"
```

3. Configure (optional) in **_config/menu.php_** :

- **_CUSTOM MIDDLEWARE:_** You can add you own middleware
- **_TABLE PREFIX:_** By default this package will create 2 new tables named "menus" and "menu_items" but you can still add your own table prefix avoiding conflict with existing table
- **_TABLE NAMES_** If you want use specific name of tables you have to modify that and the migrations
- **_Custom routes_** If you want to edit the route path you can edit the field
- **_Role Access_** If you want to enable roles (permissions) on menu items
- **_CACHE ENABLED:_** Set this to `true` if you want to enable caching for menu items. Default is `false`.
- **_CACHE KEY PREFIX:_** The prefix to use for cache keys. Default is `'menu'`.
- **_CACHE TTL:_** The time-to-live (in minutes) for cached menu items. Default is `60`.

4. Run migrate

```php
php artisan migrate
```

DONE

### Menu Builder Usage Example - displays the builder

On your view blade file

```php
@extends('app')

@section('contents')
    {!! Menu::render() !!}
@endsection

//YOU MUST HAVE JQUERY LOADED BEFORE menu scripts
@push('scripts')
    {!! Menu::scripts() !!}
@endpush
```

### Using The Model

Call the model class

```php
use NguyenHuy\Menu\Models\Menus;
use NguyenHuy\Menu\Models\MenuItems;

```

### Menu Usage Example (a)

A basic two-level menu can be displayed in your blade template

##### Using Model Class
```php

/* get menu by id*/

$menu = Menus::find(1);
/* or by name */
$menu = Menus::where('name','Test Menu')->first();

/* or get menu by name and the items with EAGER LOADING (RECOMENDED for better performance and less query call)*/
$menu = Menus::where('name','Test Menu')->with('items')->first();
/*or by id */
$menu = Menus::where('id', 1)->with('items')->first();

//you can access by model result
$public_menu = $menu->items;

//or you can convert it to array
$public_menu = $menu->items->toArray();

```

##### or Using helper
```php
// Using Helper 
$public_menu = Menu::getByName('Public'); //return array

```

### Menu Usage Example (b)

Now inside your blade template file place the menu using this simple example

```php
<div class="nav-wrap">
    <div class="btn-menu">
        <span></span>
    </div><!-- //mobile menu button -->
    <nav id="mainnav" class="mainnav">

        @if($public_menu)
        <ul class="menu">
            @foreach($public_menu as $menu)
            <li class="">
                <a href="{{ $menu['link'] }}" title="">{{ $menu['label'] }}</a>
                @if( $menu['child'] )
                <ul class="sub-menu">
                    @foreach( $menu['child'] as $child )
                        <li class=""><a href="{{ $child['link'] }}" title="">{{ $child['label'] }}</a></li>
                    @endforeach
                </ul><!-- /.sub-menu -->
                @endif
            </li>
            @endforeach
        @endif

        </ul><!-- /.menu -->
    </nav><!-- /#mainnav -->
 </div><!-- /.nav-wrap -->
```

### HELPERS

### Get Menu Items By Menu ID

```php
use NguyenHuy\Menu\Facades\Menu;
...
/*
Parameter: Menu ID
Return: Array
*/
$menuList = Menu::get(1);
```

### Get Menu Items By Menu Name

In this example, you must have a menu named _Admin_

```php
use NguyenHuy\Menu\Facades\Menu;
...
/*
Parameter: Menu ID
Return: Array
*/
$menuList = Menu::getByName('Admin');
```

### Customization

You can edit the menu interface in **_resources/views/vendor/nguyendachuy-menu/menu-html.blade.php_**
