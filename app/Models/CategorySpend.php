<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategorySpend extends Model
{
    protected $fillable = ['name', 'user_id'];

    public function spends()
    {
        return $this->hasMany(Spend::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
