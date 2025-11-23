<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
        'price',
        'description'
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class)
            ->withTrashed()
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }
}
