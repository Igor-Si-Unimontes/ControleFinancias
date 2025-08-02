<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategorySpend extends Model
{
    protected $fillable = ['name'];

    public function spends()
    {
        return $this->hasMany(Spend::class);
    }
}
