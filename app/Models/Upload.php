<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class Upload extends Model
{

    const USER_AVATAR = 'avatar';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'field',
        'uploadable_type',
        'uploadable_id',
        'filename',
        'extension',
        'content_type',
        'byte_size',
        'path',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['url'];

    /**
     * Get url.
     */
    protected function url(): Attribute
    {
        return new Attribute(
            get: fn ($value) => Storage::disk('public')
                ->url($this->attributes['path'] . '/' . $this->attributes['filename']),
        );
    }
}
