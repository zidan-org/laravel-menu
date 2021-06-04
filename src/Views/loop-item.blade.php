<li data-id="{{$m['id']}}" class="dd-item mb-2">
    <div class="card-header">
        <span class="dd-handle"><i class="fa fa-arrows" aria-hidden="true"></i></span>
        <span class="item-title">
            <span class="menu-item-title"> 
                {{$m['label']}}
            </span>
            <span style="color: transparent;">|{{$m['id']}}|</span>
        </span>
        <div class="card-link float-right" data-toggle="collapse" href="#collapse{{$m['id']}}">
            <span class="item-controls"> 
                <span class="item-type">Link <i class="fa fa-pencil-square-o" aria-hidden="true"></i></span>
            </span>
        </div>
    </div>
    {{-- @if($key == 0) show @endif --}}
    <div id="collapse{{$m['id']}}" class="collapse " data-parent="#accordion">
        <div class="card-body">
            <div class="menu-item-settings" id="menu-item-settings-{{$m['id']}}">
                <input type="hidden" class="edit-menu-item-id" name="menuid_{{$m['id']}}" value="{{$m['id']}}" />
                <div class="form-group">
                    <label for="">Label</label>
                    <input id="idlabelmenu_{{$m['id']}}" class="form-control edit-menu-item-title" 
                    name="idlabelmenu_{{$m['id']}}" value="{{$m['label']}}">
                </div>
                <div class="form-group">
                    <label for="">Class CSS (optional)</label>
                    <input id="clases_menu_{{$m['id']}}" class="form-control edit-menu-item-classes" 
                    name="clases_menu_{{$m['id']}}" value="{{$m['class']}}">
                </div>
                <div class="form-group">
                    <label for="">Icon</label>
                    <input id="icon_menu_{{$m['id']}}" class="form-control edit-menu-item-icon" 
                    name="icon_menu_{{$m['id']}}" value="{{$m['icon']}}">
                </div>
                <div class="form-group">
                    <label for="">Url</label>
                    <input id="url_menu_{{$m['id']}}" class="form-control edit-menu-item-url" 
                    name="url_menu_{{$m['id']}}" value="{{$m['link']}}">
                </div>
                @if(!empty($roles))
                <div class="form-group">
                    <label for="edit-menu-item-role-{{$m['id']}}">Role</label>
                    <select id="role_menu_{{$m['id']}}" class="form-control edit-menu-item-role" 
                        name="role_menu_[{{$m['id']}}]" >
                        <option value="0">Select Role</option>
                        @foreach($roles as $role)
                            <option @if($role->id == $m['role_id']) selected @endif value="{{ $role->$role_pk }}">
                                {{ ucwords($role->$role_title_field) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div id="update-nav-menu">
                    <a onclick="deleteItem({{$m['id']}})" class="btn btn-danger btn-sm" 
                        id="delete-{{$m['id']}}" href="javascript:void(0)">Delete</a>
                    <a onclick="updateItem({{$m['id']}})" class="btn btn-primary btn-sm" 
                        id="update-{{$m['id']}}" href="javascript:void(0)">Update item</a>
                </div>
            </div>
        </div>
    </div>
    @if (isset($m['child']) && count($m['child']) > 0)
    <ol class="dd-list">
        @foreach($m['child'] as $_m)
            @include('vendor.wmenu.loop-item', ['m' => $_m, 'key' => 1])
        @endforeach
    </ol>
    @endif
</li>
