<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Admin_access_menu;
use App\Models\Admin_prodi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AdminUserController extends Controller
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

    function index()
    {
        return view('admin.user');
    }

    function post_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'admin_roles_id' => 'required',
            // 'admin_prodis_id' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        $user = User::where('email', $request->email)->first();

        Admin::create([
            'users_id' => $user->id,
            'admin_roles_id' => $request->admin_roles_id,
            'admin_prodis_id' => 1,
            // 'admin_prodis_id' => $request->admin_prodis_id,
        ]);

        //return response
        return response()->json([
            'success' => true,
            'icon' => 'success',
            'title' => 'Admin User',
            'text' => 'Data Berhasil Disimpan!',
            'data'    => ''
        ]);
    }

    function get_show($admins_id)
    {
        $admin = Admin::with('user', 'admin_role', 'admin_prodi')->find($admins_id);

        return response()->json([
            'success' => true,
            'title' => 'Role',
            'data'    => $admin
        ]);
    }

    function put_update(Request $request, $admins_id)
    {
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required',
        //     'email' => 'required|email|unique:users,email',
        //     'password' => 'required|min:8',
        //     'admin_roles_id' => 'required',
        //     'admin_prodis_id' => 'required',
        // ]);

        // //check if validation fails
        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), 422);
        // }

        // User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => $request->password,
        // ]);

        // $user = User::where('email', $request->email)->first();

        Admin::find($admins_id)->update([
            'admin_roles_id' => $request->admin_roles_id,
            'admin_prodis_id' => 1,
            // 'admin_prodis_id' => $request->admin_prodis_id,
        ]);

        //return response
        return response()->json([
            'success' => true,
            'icon' => 'success',
            'title' => 'Admin User',
            'text' => 'Data Berhasil Diubah!',
            'data'    => ''
        ]);
    }

    function delete_destroy($admins_id)
    {
        $admin = Admin::find($admins_id);
        Admin::destroy($admins_id);
        User::destroy($admin->users_id);

        return response()->json([
            'success' => true,
            'icon' => 'warning',
            'title' => 'Admin User',
            'text' => 'Data Telah Dihapus!',
            'data'    => ''
        ]);
    }




    function get_datatable(Request $request)
    {

        $data = Admin::get();

        // return response()->json($data);
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('name', function ($data) {
                    return $data->user->name;
                })
                ->addColumn('email', function ($data) {
                    return $data->user->email;
                })
                ->addColumn('admin_role', function ($data) {
                    return $data->admin_role->name;
                })
                ->addColumn('admin_prodi', function ($data) {
                    return $data->admin_prodi->name;
                })
                ->addColumn('action', function ($data) {
                    // return $data->a;
                    return '<div style="display: inline-flex;" class="">
                            <a href="javascript:void(0)" id="btn-edit" data-id="' . $data->id . '" class="btn btn-sm btn-info mr-2">Edit</a>
                            <a href="javascript:void(0)" id="btn-delete" data-id="' . $data->id . '" class="btn btn-sm btn-danger">Delete</a>
                            </div>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
    }
}
