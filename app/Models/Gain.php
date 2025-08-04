<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gain extends Model
{
    protected $fillable = ['name', 'amount', 'date', 'user_id', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
