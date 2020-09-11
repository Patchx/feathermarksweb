<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\Http\Requests\CreateLinkRequest;

use App\Link;

// WIP
class LinkAjaxController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

    public function postCreate(CreateLinkRequest $request)
    {
    	$user = Auth::user();
        $url = $request->url;

        $starts_with_protocol = (
            strpos($url, "https://") === 0
            || strpos($url, "http://") === 0
        );

        if (!$starts_with_protocol) {
            $url = '//' . $url;
        }

    	Link::create([
    		'user_id' => $user->custom_id,
    		'folder_id' => null,
    		'category' => $request->category,
    		'name' => $request->name,
    		'url' => $url,
    	]);

        return json_encode([
            'status' => 'success',
        ]);
    }

    public function postDelete($link_id)
    {
        $user = Auth::user();

        $link = Link::where('custom_id', $link_id)
                    ->where('user_id', $user->custom_id)
                    ->first();

        if ($link !== null) {
            $link->delete();
        }

        return json_encode([
            'status' => 'success',
        ]);
    }
}
