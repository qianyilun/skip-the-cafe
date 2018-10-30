<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'title',
        'description',
        'owner',
        'taker',
    ];
    public function user() {
      return $this->belongsTo('App\User'); // tells ORM that every post belongs to a user
    }
}
