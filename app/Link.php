<?php

namespace App;

class Link extends AbstractModel
{
    // --------------
    // - Attributes -
    // --------------

    protected $fillable = [
    	'created_at',
    	'updated_at',
        'custom_id',
        'user_id',
        'folder_id',
        'category',
        'name',
        'url',
    ];

    // -----------------
    // - Relationships -
    // -----------------

    public function user()
    {
        return User::where('custom_id', $this->user_id)->first();
    }
}
