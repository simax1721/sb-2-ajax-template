<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin_access_menu;
use App\Models\Admin_menu;
use App\Models\Admin_role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AdminRoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $middleware = 'admincek:';
        $admin_access_menu = Admin_access_menu::where('admin_menus_id', 2)->get();
        foreach ($admin_access_menu as $access_id) {
            $middleware = $middleware . strval($access_id->admin_roles_id) . '|';
        }
        // dd($middleware);
        $this->middleware($middleware);
        // $this->middleware('admin:1|2|');
    }

    function get_index()
    {
        return view('admin.role');
    }

    function post_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        Admin_role::create([
            'name' => $request->name,
        ]);

        //return response
        return response()->json([
            'success' => true,
            'icon' => 'success',
            'title' => 'Role',
            'text' => 'Data Berhasil Disimpan!',
            'data'    => ''
        ]);
    }

    function get_show(Admin_role $admin_role)
    {
        return response()->json([
            'success' => true,
            'title' => 'Role',
            'data'    => $admin_role
        ]);
    }

    function get_showAccess($admin_roles_id)
    {
        $admin_role = Admin_role::find($admin_roles_id);
        $admin_menu = Admin_menu::select('id', 'name')->get();

        return view('admin.role-access-menu', compact('admin_role', 'admin_menu', 'admin_roles_id'));
    }

    function get_changeAccess(Request $request, $menu_id, $role_id)
    {
        $data = [
            'admin_roles_id' => $role_id,
            'admin_menus_id' => $menu_id,
        ];

        $admin_access_menu = Admin_access_menu::where('admin_menus_id', $menu_id)->where('admin_roles_id', $role_id)->get();

        // return $admin_access_menu;

        if (count($admin_access_menu) < 1) {
            Admin_access_menu::create($data);
        } else {
            Admin_access_menu::where('admin_menus_id', $menu_id)->where('admin_roles_id', $role_id)->delete();
        }

        return response()->json([
            'success' => true,
            'title' => 'Access Role',
            'data'    => ''
        ]);
    }

    function post_update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        Admin_role::find($id)->update([
            'name' => $request->name,
        ]);

        //return response
        return response()->json([
            'success' => true,
            'icon' => 'success',
            'title' => 'Role',
            'text' => 'Data Berhasil Diubah!',
            'data'    => ''
        ]);
    }


    function get_datatable(Request $request)
    {

        $data = Admin_role::get();

        // return response()->json($data);
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('name', function ($data) {
                    return $data->name;
                })
                ->addColumn('action', function ($data) {
                    // return $data->a;
                    return '<div style="display: inline-flex;" class="">
                            <a href="' . url('admin/role/show-access/' . $data->id) . '" id="btn-access" data-id="' . $data->id . '" class="btn btn-sm btn-warning mr-2">Access</a>
                            <a href="javascript:void(0)" id="btn-edit" data-id="' . $data->id . '" class="btn btn-sm btn-info mr-2">Edit</a>
                            <a href="javascript:void(0)" id="btn-delete" data-id="' . $data->id . '" class="btn btn-sm btn-danger">Delete</a>
                            </div>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    function delete_destroy($id)
    {
        Admin_role::destroy($id);

        return response()->json([
            'success' => true,
            'icon' => 'warning',
            'title' => 'Role',
            'text' => 'Data Telah Dihapus!',
            'data'    => ''
        ]);
    }

    function get_roleAjax(Request $request)
    {
        $data = [];

        if ($request->has('q')) {
            $search = $request->q;
            $data = Admin_role::select("id", "name")->where('name', 'LIKE', "%$search%")->orWhere('id', '=', "$search")->get();
        } else {
            $data = Admin_role::select("id", "name")->get();
        }
        return response()->json($data);
    }
}
