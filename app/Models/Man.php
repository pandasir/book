<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Man extends Model
{
    public $table = 'man';

    public $guarded = [];

    public $timestamps = true;

    public function manHan()
    {
        return $this->hasOne('App\Models\ManHan', 'man_id', 'id');
    }
}
