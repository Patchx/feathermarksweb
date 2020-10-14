<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\Http\Requests\CreateLinkRequest;

use App\Classes\Repositories\LinkRepository;

use App\Category;
use App\Link;

class LinkAjaxController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

    public function getMyLinks(
        LinkRepository $link_repo,
        Request $request
    ) {
        $user = Auth::user();
        $category = $link_repo->getUserCategory($request->cat_id, $user);

        $links = Link::where('user_id', $user->custom_id)
                    ->where('category_id', $category->custom_id)
                    ->get();

        return json_encode([
            'status' => 'success',
            'links' => $links,
        ]);
    }

    public function getSearchMyLinks(
        LinkRepository $link_repo,
        Request $request
    ) {
        $user = Auth::user();
        $category = $link_repo->getUserCategory($request->cat_id, $user);

        $links = Link::search($request->q)
                    ->where('user_id', $user->custom_id)
                    ->where('category_id', $category->custom_id)
                    ->get();

        return json_encode([
            'status' => 'success',
            'links' => $links,
        ]);
    }

    public function postCreate(
        LinkRepository $link_repo,
        CreateLinkRequest $request
    ) {
    	$user = Auth::user();
        $url = $request->url;

        $starts_with_protocol = (
            strpos($url, "https://") === 0
            || strpos($url, "http://") === 0
        );

        if (!$starts_with_protocol) {
            $url = '//' . $url;
        }

        $category = $link_repo->getUserCategory(
            $request->category_id, $user
        );

        $instaopen_command = trim($request->instaopen_command, ' /');

    	$new_link = Link::create([
    		'user_id' => $user->custom_id,
    		'folder_id' => null,
    		'category_id' => $category->custom_id,
    		'name' => $request->name,
    		'url' => $url,
            'search_phrase' => $request->search_phrase,
            'instaopen_command' => $instaopen_command,
    	]);

        return json_encode([
            'status' => 'success',
            'link' => $new_link,
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

        return json_encode(['status' => 'success']);
    }

    // Assuming only instaopen commands for now
    // --
    public function postRunFeatherCommand(
        LinkRepository $link_repo,
        Request $request
    ) {
        $user = Auth::user();

        $category = $link_repo->getUserCategory(
            $request->category_id, $user
        );

        $command = trim($request->command, ' /');

        $link = Link::where('user_id', $user->custom_id)
                    ->where('instaopen_command', $command)
                    ->where('category_id', $category->custom_id)
                    ->first();

        if ($link === null) {
            return json_encode(['status' => 'command_not_found']);
        }

        return json_encode([
            'status' => 'success',
            'directive' => 'open_link',
            'url' => $link->url,
        ]);
    }
}
