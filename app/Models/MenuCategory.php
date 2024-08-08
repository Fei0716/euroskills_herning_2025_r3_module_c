<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuCategory extends Model
{
    use HasFactory;
    protected $table = 'menucategory';
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

}
