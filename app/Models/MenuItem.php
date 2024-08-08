<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;
    protected $table = 'menuitem';
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    public function orderItems(){
        return $this->hasMany(OrderItem::class, 'menuItemId' , 'id');
    }
}
