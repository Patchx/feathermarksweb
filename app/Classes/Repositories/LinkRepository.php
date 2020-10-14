<?php

namespace App\Classes\Repositories;

use App\Category;
use App\User;

class LinkRepository
{
	public function getUserCategory($category_id, User $user)
	{
		if ($category_id === null) {
		    return Category::where('user_id', $user->custom_id)->first();
		}

	    $category = Category::where('user_id', $user->custom_id)
	                        ->where('custom_id', $category_id)
	                        ->first();

	    if ($category !== null) {
	    	return $category;
	    }

        return Category::where('user_id', $user->custom_id)->first();
	}
}

