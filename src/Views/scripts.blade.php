<script>
	var arraydata = [];     
	var addCustomMenur= '{{ route("hAddCustomMenu") }}';
	var updateItemr= '{{ route("hUpdateItem")}}';
	var generateMenuControlr= '{{ route("hGenerateMenuControl") }}';
	var deleteItemMenur= '{{ route("hDeleteItemMenu") }}';
	var deleteMenugr= '{{ route("hDeleteMenug") }}';
	var createNewMenur= '{{ route("hCreateNewMenu") }}';
	var csrftoken="{{ csrf_token() }}";
	var menuwr = "{{ url()->current() }}";
	var currentItem = "{{ request()->fullUrl() }}";

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': csrftoken
		}
	});
</script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/nestable2@1.6.0/jquery.nestable.min.js"></script>
<script type="text/javascript" src="{{asset('vendor/nguyendachuy-menu/menu.js')}}"></script>