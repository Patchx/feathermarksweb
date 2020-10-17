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
        $active_category_name = 'personal';
        $categories = Category::where('user_id', $user->custom_id)->get();

        foreach ($categories as $category) {
            if ($category->custom_id === $request->cat_id) {
                $active_category_name = $category->name;
                break;
            }
        }

        if ($request->cat_id === null) {
            $html_title = 'FeatherMarks';
        } else {
            $html_title = 'FeatherMarks - ' . ucwords($active_category_name);
        }

        $data = [
            'active_category_name' => $active_category_name,
            'categories' => $categories,
            'request_category_id' => $request->cat_id,
            'html_title' => $html_title,
        ];

        return view('home', $data);
    }
}
