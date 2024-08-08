<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;
    protected $table = 'table';
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    public $appends = ['hasOpenOrder'];
    public function orders(){
        return $this->hasMany(Order::class, 'tableId', 'id');
    }
    public function getHasOpenOrderAttribute(): bool
    {
        return (bool)$this->orders()->whereNull('closedAt')->first();
    }
}
