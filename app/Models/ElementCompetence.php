<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Critere;
use App\Models\NiveauEtude;
class ElementCompetence extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        "code",
        "nom",
        "competence_id",
        "metier_id",
	"niveau_etude_id",
        "description",
       
    ];

    public function listes(): MorphMany
    {
        return $this->morphMany(Liste::class, 'listeable');
    }

    public function projets()
    {
        return $this->hasMany(Projet::class);
    }


    public function competence()
    {
        return $this->belongsTo(Competence::class);
    }

    public function metier()
    {
        return $this->belongsTo(Metier::class);
    }
  public function criteres()
    {
        return $this->hasMany(Critere::class, 'element_competence_id');
    }
public function niveauEtude()
{
    return $this->belongsTo(NiveauEtude::class, 'niveau_etude_id');
}

}


