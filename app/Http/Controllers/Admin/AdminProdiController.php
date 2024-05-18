<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin_access_menu;
use App\Models\Admin_prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AdminProdiController extends Controller
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
        return view('admin.prodi');
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

        Admin_prodi::create([
            'name' => $request->name,
        ]);

        //return response
        return response()->json([
            'success' => true,
            'icon' => 'success',
            'title' => 'Prodi',
            'text' => 'Data Berhasil Disimpan!',
            'data'    => ''
        ]);
    }

    function get_show(Admin_prodi $admin_prodi)
    {
        return response()->json([
            'success' => true,
            'title' => 'prodi',
            'data'    => $admin_prodi
        ]);
    }

    function put_update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        Admin_prodi::find($id)->update([
            'name' => $request->name,
        ]);

        //return response
        return response()->json([
            'success' => true,
            'icon' => 'success',
            'title' => 'Prodi',
            'text' => 'Data Berhasil Diubah!',
            'data'    => ''
        ]);
    }

    function delete_destroy($id)
    {
        Admin_prodi::destroy($id);

        return response()->json([
            'success' => true,
            'icon' => 'warning',
            'title' => 'Prodi',
            'text' => 'Data Telah Dihapus!',
            'data'    => ''
        ]);
    }




    function get_datatable(Request $request)
    {

        $data = Admin_prodi::get();

        // return response()->json($data);
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('name', function ($data) {
                    return $data->name;
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

    function get_prodiAjax(Request $request)
    {
        $data = [];

        if ($request->has('q')) {
            $search = $request->q;
            $data = Admin_prodi::select("id", "name")->where('name', 'LIKE', "%$search%")->orWhere('id', '=', "$search")->get();
        } else {
            $data = Admin_prodi::select("id", "name")->get();
        }
        return response()->json($data);
    }
}
