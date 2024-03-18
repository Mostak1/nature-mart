<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
     use HasFactory, SoftDeletes;
    protected $fillable = [
        'supplier_id', 'total','user_id', 
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }
}
