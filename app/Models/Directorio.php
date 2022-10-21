<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Directorio extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'usuario_de_red',
        'correo',
        'extension',
        'dependencia_id',
        'area_id',
    ];

    public function dependencia(){
        return $this->belongsTo(Dependencia::class);
    }

    public function area(){
        return $this->belongsTo(Area::class);
    }

    public function issue(){
        return $this->hasMany(Issue::class);
    }
}
