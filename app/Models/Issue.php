<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use HasFactory;

    protected $fillable = [
        'directorio_id',
        'text',
        'ip_issue_sender',
    ];


    public function directorio(){
        return $this->belongsTo(Directorio::class);
    }
}
