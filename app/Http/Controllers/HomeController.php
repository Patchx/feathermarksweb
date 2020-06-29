<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

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

        $data = [
            'category' => $category,
            'links' => $user->links(),
        ];

        return view('home', $data);
    }
}
