@extends('layouts.admin') 

@section('main-content')
@php
    use App\Models\Admin_access_menu;
@endphp
<!-- Page Heading -->
<h1 class="h3 mb-0 text-gray-800 mb-4">Role</h1>

<div class="row">

    <div class="col-md-7">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
          <h6 class="mt-2 font-weight-bold text-primary">Data Role: {{ $admin_role->name }}</h6>
      </div>
      <div class="card-body">
        @foreach ($admin_menu as $am)
            @php
                $admin_access_menu = Admin_access_menu::where('admin_roles_id', $admin_roles_id)->where('admin_menus_id', $am->id)->select('id', 'admin_roles_id', 'admin_menus_id')->get();
            @endphp
            <div class="row d-flex justify-content-beetwen mb-2">
              <div class="col" style="font-size: 16px">
                {{ $am->name }}
              </div>
              <div class="col text-right">
                <div class="form-check">
                  <input class="form-check-input position-static" style="transform: scale(2)" type="checkbox" data-role="{{ $admin_roles_id }}" data-menu="{{ $am->id }}" {{ (count($admin_access_menu) > 0 ? "checked" : "") }} >
                </div>
              </div>
            </div>
        @endforeach
      </div>
    </div>
    
    
    </div>
</div>
@endsection 

@push('scripts')
  <script>
     $('.form-check-input').on('click', function() {
        const menuId = $(this).data('menu');
        const roleId = $(this).data('role');

        $.ajax({
            url: `{{ url('admin/role/change-access/${menuId}/${roleId}') }}`,
            type: 'get',
            cache: false,
            data: {
                menuId: menuId,
                roleId: roleId
            },
            success: function() {
              location.reload();
            },
        });
    });
  </script>

@endpush