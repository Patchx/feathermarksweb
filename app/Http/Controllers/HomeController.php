<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\Link;

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
        $category = $request->cat;

        if ($category === null) {
            $category = 'personal';
        }

        $links = Link::where('user_id', $user->custom_id)
                    ->where('category', $category)
                    ->get();

        $data = [
            'category' => $category,
            'links' => $links,
        ];

        return view('home', $data);
    }
}
