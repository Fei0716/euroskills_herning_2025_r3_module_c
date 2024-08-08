<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $table = 'orderitem';
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    public function menuItem(){
        return $this->belongsTo(MenuItem::class, 'menuItemId', 'id');
    }
}
