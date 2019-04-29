<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManHan extends Model
{
    public $table = 'man_han';

    public $guarded = [];

    public $timestamps = true;

    public function man()
    {
        return $this->belongsTo('App\Models\Man');
    }
}
