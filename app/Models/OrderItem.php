<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'menu_id',
        'quantity',
        'price',
        'option_wasabi', 
        'option_rice_size'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    
    // メニューとのリレーション
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

}
