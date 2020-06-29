<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\Http\Requests\CreateLinkRequest;

use App\Link;

class LinkWebController extends Controller
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

    	return redirect()->back()->with('msg_success', 'Link created successfully');
    }

    public function postDelete($link_id)
    {
        $user = Auth::user();

        $link = Link::where('custom_id', $link_id)
                    ->where('user_id', $user->custom_id)
                    ->first();

        if ($link === null) {
            return redirect()->back()->with('msg_failure', 'Unable to delete this link');
        }

        $link->delete();

        return redirect()->back()->with('msg_success', 'Link deleted successfully');
    }
}