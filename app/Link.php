<?php

namespace App;

use Laravel\Scout\Searchable;

class Link extends AbstractModel
{
    use Searchable;

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

    // ---------------------------
    // - Laravel Scout Overrides -
    // ---------------------------

    /**
     * Get the value used to index the model.
     *
     * @return mixed
     */
    public function getScoutKey()
    {
        return $this->custom_id;
    }

    /**
     * Get the key name used to index the model.
     *
     * @return mixed
     */
    public function getScoutKeyName()
    {
        return 'custom_id';
    }
}
