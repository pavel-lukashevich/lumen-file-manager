<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * @var array
     */
    protected $visible = ['id', 'name', 'average_rate', 'file_count'];

    /**
     * @var array
     */
    protected $appends = ['file_count'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function files()
    {
        return $this->belongsToMany(File::class);
    }

    /**
     * @return int
     */
    public function getFileCountAttribute()
    {
        return $this->belongsToMany(File::class)->count();
    }
}
