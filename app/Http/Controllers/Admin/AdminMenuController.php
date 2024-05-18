<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin_access_menu;
use App\Models\Admin_menu;
use App\Models\Admin_sub_menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AdminMenuController extends Controller
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
        return view('admin.menu');
    }

    function post_storemenu(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        Admin_menu::create([
            'name' => $request->name,
        ]);

        //return response
        return response()->json([
            'success' => true,
            'icon' => 'success',
            'title' => 'Menu',
            'text' => 'Data Berhasil Disimpan!',
            'data'    => ''
        ]);
    }

    function get_showmenu(Admin_menu $admin_menu)
    {
        return response()->json([
            'success' => true,
            'title' => 'Menu',
            'data'    => $admin_menu
        ]);
    }

    function put_updatemenu(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        Admin_menu::find($id)->update([
            'name' => $request->name,
        ]);

        //return response
        return response()->json([
            'success' => true,
            'icon' => 'success',
            'title' => 'Menu',
            'text' => 'Data Berhasil Diubah!',
            'data'    => ''
        ]);
    }

    function delete_destroymenu($id)
    {

        Admin_menu::destroy($id);

        return response()->json([
            'success' => true,
            'icon' => 'warning',
            'title' => 'Menu',
            'text' => 'Data Telah Dihapus!',
            'data'    => ''
        ]);
        // return $admin;
    }

    function post_storesubmenu(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'icon' => 'required',
            'url' => 'required',
            'admin_menus_id' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        Admin_sub_menu::create([
            'name' => $request->name,
            'admin_menus_id' => $request->admin_menus_id,
            'url' => $request->url,
            'icon' => $request->icon,
        ]);

        //return response
        return response()->json([
            'success' => true,
            'icon' => 'success',
            'title' => 'Sub Menu',
            'text' => 'Data Berhasil Disimpan!',
            'data'    => ''
        ]);
    }

    function get_showsubmenu($id)
    {
        $admin_sub_menu = Admin_sub_menu::with('admin_menu')->find($id);
        return response()->json([
            'success' => true,
            'title' => 'Sub Menu',
            'data'    => $admin_sub_menu
        ]);
    }

    function put_updatesubmenu(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'icon' => 'required',
            'url' => 'required',
            'admin_menus_id' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        Admin_sub_menu::find($id)->update([
            'name' => $request->name,
            'admin_menus_id' => $request->admin_menus_id,
            'url' => $request->url,
            'icon' => $request->icon,
        ]);

        //return response
        return response()->json([
            'success' => true,
            'icon' => 'success',
            'title' => 'Sub Menu',
            'text' => 'Data Berhasil Diubah!',
            'data'    => ''
        ]);
    }

    function delete_destroysubmenu($id)
    {

        Admin_sub_menu::destroy($id);

        return response()->json([
            'success' => true,
            'icon' => 'warning',
            'title' => 'Sub Menu',
            'text' => 'Data Telah Dihapus!',
            'data'    => ''
        ]);
        // return $admin;
    }








    function get_menudatatable(Request $request)
    {

        $data = Admin_menu::get();

        // return response()->json($data);
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('name', function ($data) {
                    return $data->name;
                })
                ->addColumn('action', function ($data) {
                    // return $data->a;
                    return '<div style="display: inline-flex;" class="">
                            <a href="javascript:void(0)" id="btn-edit-menu" data-id="' . $data->id . '" class="btn btn-sm btn-info mr-2">Edit</a>
                            <a href="javascript:void(0)" id="btn-delete-menu" data-id="' . $data->id . '" class="btn btn-sm btn-danger">Delete</a>
                            </div>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    function get_submenudatatable(Request $request)
    {

        $data = Admin_sub_menu::get();

        // return response()->json($data);
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('name', function ($data) {
                    return $data->name;
                })
                ->addColumn('url', function ($data) {
                    return $data->url;
                })
                ->addColumn('icon', function ($data) {
                    return $data->icon;
                })
                ->addColumn('admin_menus_id', function ($data) {
                    return $data->admin_menu->name;
                })
                ->addColumn('action', function ($data) {
                    // return $data->a;
                    return '<div style="display: inline-flex;" class="">
                            <a href="javascript:void(0)" id="btn-edit-submenu" data-id="' . $data->id . '" class="btn btn-sm btn-info mr-2">Edit</a>
                            <a href="javascript:void(0)" id="btn-delete-submenu" data-id="' . $data->id . '" class="btn btn-sm btn-danger">Delete</a>
                            </div>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }

    function get_menuAjax(Request $request)
    {
        $data = [];

        if ($request->has('q')) {
            $search = $request->q;
            $data = Admin_menu::select("id", "name")->where('name', 'LIKE', "%$search%")->orWhere('id', '=', "$search")->get();
        } else {
            $data = Admin_menu::select("id", "name")->get();
        }
        return response()->json($data);
    }
}
