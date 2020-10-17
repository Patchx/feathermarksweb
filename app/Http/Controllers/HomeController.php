<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\Classes\Repositories\CategoryRepository;

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
    public function index(
        CategoryRepository $category_repo,
        Request $request
    ) {
        $user = Auth::user();
        $categories = Category::where('user_id', $user->custom_id)->get();

        $active_category = $category_repo->getUserCategory(
            $request->cat_id, $user
        );
        
        if ($request->cat_id === null) {
            $html_title = 'FeatherMarks';
        } else {
            $html_title = 'FeatherMarks - ' . ucwords($active_category->name);
        }

        $data = [
            'active_category_name' => $active_category->name,
            'categories' => $categories,
            'request_category_id' => $request->cat_id,
            'html_title' => $html_title,
        ];

        return view('home', $data);
    }
}
