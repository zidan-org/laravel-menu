@php
	$currentUrl = url()->current();
@endphp

<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link href="{{asset('vendor/nguyendachuy-menu/style.css')}}" rel="stylesheet">
<style>
	/**
	Fixes for boostrap 4.3.1*/
	/* #nguyen-huy .card-header{
		display: block;
	}
	#nguyen-huy .jumbotron .container{
		padding-top: 5px;
	} */
</style>
<div id="nguyen-huy" class="card mt-2 mb-2">
	<div class="card-header">
		<form method="GET" action="{{ $currentUrl }}" class="form-inline">
			<label for="email" class="mr-sm-2">Select the menu you want to edit: </label>
			{!! Menu::select('menu', $menulist, ['class' => 'form-control']) !!}
			<button type="submit" class="btn btn-primary ml-2">Submit</button>
			<div class="ml-4 mb-2 mr-sm-2">
				or <a href="{{ $currentUrl }}?action=edit&menu=0">Create New Menu</a>
			</div>
		</form>
	</div>
	
	<div class="card-body">
		<input type="hidden" id="idmenu" value="{{$indmenu->id ?? null}}"/>
		<div class="row">
			<div class="col-md-4">
				@if(!empty(request()->get('menu')))
				<form method="GET">
					@php
						$pages = [
							[
								'url' => '/page1',
								'icon' => '',
								'label' => 'Home Page',
							],
							[
								'url' => '/page2',
								'icon' => '',
								'label' => 'Contact Us',
							]
						];
					@endphp
					{{-- @php
						$pages = \App\Pages::get(['id', 'title'])->map(function($page){
							return [
								'url' => $page->getLink(),
								'icon' => '',
								'label' => $page->title,
							];
						});
					@endphp --}}
					<div class="form-group">
						<label for="label">Select Pages</label>
						<!-- <select name="pages" class="form-control data-select" required> -->
						<select name="pages[]" multiple class="form-control data-select" required>
							@foreach ($pages as $page)
								<option 
									value="{{$page['url']}}" 
									data-icon="{{$page['icon']}}"
									data-url="{{$page['url']}}"
									>{{$page['label']}}</option>
							@endforeach
						</select>
					</div>
					{{-- @php
						$blogs = \App\Blog::get(['id', 'title'])->map(function($blog){
							return [
								'url' => $blog->getLink(),
								'icon' => '',
								'label' => $blog->title,
							];
						});
					@endphp
					<div class="form-group">
						<label for="label">Select Blogs</label>
						<select name="blogs[]" multiple class="form-control data-select" required>
							@foreach ($blogs as $blog)
								<option 
									value="{{$blog['url']}}" 
									data-icon="{{$blog['icon']}}"
									data-url="{{$blog['url']}}"
									>{{$blog['label']}}</option>
							@endforeach
						</select>
					</div> --}}
					@if(!empty($roles))
					<div class="form-group">
						<label for="role">Example select</label>
						<select class="form-control" name="role">
							<option value="0">Select Role</option>
							@foreach($roles as $role)
								<option value="{{ $role->$role_pk }}">
									{{ ucfirst($role->$role_title_field) }}
								</option>
							@endforeach
						</select>
					</div>
					@endif
					<div class="form-group">
						<button type="button" onclick="addCustomMenu(this, 'custom')" class="btn btn-info btn-sm">
							Add Menu Items
						</button>
					</div>
				</form>
				<hr>
				<form method="GET">
					<div class="form-group">
						<label for="label">Enter Label</label>
						<input type="text" class="form-control" name="label" placeholder="Label Menu">
					</div>
					<div class="form-group">
						<label for="url">Enter URL</label>
						<input type="text" class="form-control" name="url" placeholder="#">
					</div>
					<div class="form-group">
						<label for="icon">Enter Icon</label>
						<input type="text" class="form-control" id="iconHelp" name="icon" placeholder="Icon">
						<small id="iconHelp" class="form-text text-muted">
							Ex: &lt;span class=&quot;oi oi-align-center&quot;&gt;&lt;/span&gt;
						</small>
					</div>
					@if(!empty($roles))
					<div class="form-group">
						<label for="role">Example select</label>
						<select class="form-control" name="role">
							<option value="0">Select Role</option>
							@foreach($roles as $role)
								<option value="{{ $role->$role_pk }}">
									{{ ucfirst($role->$role_title_field) }}
								</option>
							@endforeach
						</select>
					</div>
					@endif
					<div class="form-group">
						<button type="button" onclick="addCustomMenu(this, 'default')" class="btn btn-info btn-sm">
							Add Menu Item
						</button>
					</div>
				</form>
				@endif
			</div>
			{{-- /col-md-4 --}}
			<div class="col-md-8">
				<div class="card mt-2">
					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<form class="form-inline" action="" method="post">
									<div class="form-group">
										<label for="email" class="mr-sm-2">Name: </label>
										<input name="menu-name" id="menu-name" type="text" 
										class="form-control menu-name regular-text menu-item-textbox" 
										title="Enter menu name" value="@if(isset($indmenu)){{$indmenu->name}}@endif">
										@if(request()->has('action'))
											<a onclick="createNewMenu()" name="save_menu" 
												class="btn btn-primary menu-save ml-2">Create Menu</a>
										@elseif(request()->has('menu'))
											<a onclick="actualizarMenu(false)" name="save_menu"
												class="btn btn-primary menu-save ml-2">Save Menu</a>
										@else
											<a onclick="createNewMenu()" name="save_menu" 
												class="btn btn-primary menu-save ml-2">Create Menu</a>
										@endif
									</div>
								</form>
								<hr>
							</div>
							<div class="col-md-12">
								@if(request()->get('menu') != 0 && isset($menus) && count($menus) > 0)
								<div class="jumbotron jumbotron-fluid p-2">
									<div class="container">
										<h3>Menu Structure</h3>
										<p class="lead">Place each item in the order you prefer. Click <i class="fa fa-pencil-square-o" aria-hidden="true"></i> to the right of the item to display more configuration options.</p>
									</div>
								</div>
								@elseif(request()->get('menu') == 0)
								<div class="jumbotron jumbotron-fluid p-2">
									<div class="container">
										<h3>Menu Creation</h3>
										<p class="lead">Please enter the name and select "Create menu" button</p>
									</div>
								</div>
								@else
								<div class="jumbotron jumbotron-fluid p-2">
									<div class="container">
										<h3>Create Menu Item</h3>
										<p class="lead"></p>
									</div>
								</div>
								@endif

								<div id="accordion" class="">
									@if(isset($menus) && count($menus) > 0)
									<div class="dd nestable-menu" id="nestable">
										<ol class="dd-list">	
											@foreach($menus as $key => $m)
												@include('vendor.wmenu.loop-item', ['key' => $key])
											@endforeach
										</ol>
									</div>
									@endif
								</div>
							</div>
						</div>
					</div>
					@if(request()->get('menu') != 0)
					<div class="card-footer">
						<a class="btn btn-danger btn-sm submitdelete deletion menu-delete" 
							onclick="deleteMenu()" href="javascript:void(9)">Delete Menu
						</a>
						@if(isset($menus) && count($menus) > 0)
						<a class="btn btn-info btn-sm" 
							onclick="updateItem()" href="javascript:void(9)">Update All Item
						</a>
						@endif
					</div>
					@endif
				</div>
			</div>
		</div>
	</div>

	<div class="ajax-loader" id="ajax_loader">
		<div class="lds-ripple"><div></div><div></div></div>
	</div>
</div>