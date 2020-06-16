<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sales extends Model
{
    protected $table = 'sales';
    protected $fillable = ['buyer_id', 'sale_amount'];

 public function buyers() {
     return $this->hasMany(buyers::class);
 }
}
