<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManDetail extends Model
{
    public $table = 'man_detail';

    public $guarded = [];

    public $timestamps = true;

    public function man()
    {
        return $this->belongsTo('App\Models\Man');
    }
}
