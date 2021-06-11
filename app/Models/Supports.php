<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supports extends Model
{
    use HasFactory;

    public function Messages()
    {
        return $this->hasMany(Messages::class, 'support_id', 'id');
    }
}
