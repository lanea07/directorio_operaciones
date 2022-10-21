<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gerencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
    ];

    public function Area(){
        return $this->hasMany(Area::class)->orderBy('nombre', 'asc');
    }
}
