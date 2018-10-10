<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $table = 'cards';
    protected $fillable = ['name', 'lists_id', 'description'];

    public function list()
    {
        return $this->belongsTo(Lists::class, 'lists_id'); //Providing a foreign keym, it is necessary
    }
}
