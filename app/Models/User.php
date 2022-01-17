<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function __construct(array $attributes = [])
    {
        $this->timestamps = false;
        parent::__construct($attributes);
    }

    use HasFactory;
   // public $timestamps = false;
}
