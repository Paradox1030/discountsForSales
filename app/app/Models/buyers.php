<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class buyers extends Model
{
    protected $table = 'buyers';
    protected $fillable = ['first_name', 'second_name', 'patronymic'];
}
