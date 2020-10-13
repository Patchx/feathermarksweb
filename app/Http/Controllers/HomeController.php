<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\Category;

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
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $categories = Category::where('user_id', $user->custom_id)->get();

        $data = [
            'categories' => $categories,
            'category_id' => $request->cat_id,
        ];

        return view('home', $data);
    }
}
