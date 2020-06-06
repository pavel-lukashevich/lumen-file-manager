<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user', 'file', 'rating'];

    /**
     * @var array
     */
    protected $appends = ['user', 'file'];



    public function getUserAttribute()
    {
        return $this->belongsTo(User::class);
    }


    public function getFileAttribute()
    {
        return $this->belongsTo(File::class);
    }
}
