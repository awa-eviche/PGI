<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evalute extends Model
{
    use HasFactory;
    protected $fillable = [
        "inscription_id",
        "critere_id",
      
        "semestre",
     
        "date",
      "note",
      
    ];
    public function critere()
    {
        return $this->belongsTo(Critere::class);
    }
}

