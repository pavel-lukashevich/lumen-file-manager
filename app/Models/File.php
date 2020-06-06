<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'path', 'extension',];

    /**
     * @var array
     */
    protected $visible = ['name', 'download_count', 'average_rate'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
