<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id', 'mobile', 'address', 'card_number', 'valid_date', 'active_date', 'total_meal', 'consumed_meal', 'menu_id', 'card_status',
    ];
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
