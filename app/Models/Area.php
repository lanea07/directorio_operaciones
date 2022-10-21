<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'gerencia_id',
    ];

    public function gerencia(){
        return $this->belongsTo(Gerencia::class);
    }

    public function directorio(){
        return $this->hasMany(Directorio::class);
    }
}
