<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Admin;
use App\Models\Admin_access_menu;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        $middleware = 'admincek:';
        $admin_access_menu = Admin_access_menu::where('admin_menus_id', 1)->get();
        foreach ($admin_access_menu as $access_id) {
            $middleware = $middleware . strval($access_id->admin_roles_id) . '|';
        }
        // dd($middleware);
        $this->middleware($middleware);
        // $this->middleware('admin:1|2|4');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::count();

        $widget = [
            'users' => $users,
            //...
        ];

        return view('home', compact('widget'));
    }
}
