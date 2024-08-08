<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'order';
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    public function orderItems(){
        return $this->hasMany(OrderItem::class, 'orderId', 'id');
    }
}
