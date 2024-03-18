<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OffOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tab_id','total','user_id','discount','reason'
    ];

    public function offorderdetails()
    {
        return $this->hasMany(OffOrderDetails::class);
    }
    public function tab(){
        return $this->belongsTo(Tab::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
