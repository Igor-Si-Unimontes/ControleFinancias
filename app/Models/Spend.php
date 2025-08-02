<?php

namespace App\Models;

use App\Enums\FinancialPaymentMethod;
use Illuminate\Database\Eloquent\Model;

class Spend extends Model
{
    protected $fillable = [
        'name',
        'amount',
        'date',
        'category',
        'payment_method',
        'description',
        'user_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'date' => 'date',
        'payment_method' => FinancialPaymentMethod::class,
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function categorySpend()
    {
        return $this->belongsTo(CategorySpend::class, 'category');
    }
}
