<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\NiveauEtude;
use App\Models\Metier;

class Matiere extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        "code",
        "nom",
        "coef",
        "niveau_etude_id",
        "metier_id",

        "description",
       
    ];

public function getCoefAttribute($value)
    {
        // si la partie décimale est 0, retourne entier
        if (fmod($value, 1) == 0) {
            return (int) $value;
        }
    
        return rtrim(rtrim($value, '0'), '.'); // sinon on enlève juste les zéros inutiles
    }
    public function listes(): MorphMany
    {
        return $this->morphMany(Liste::class, 'listeable');
    }

    public function projets()
    {
        return $this->hasMany(Projet::class);
    }


    public function niveau_etude()
    {
        return $this->belongsTo(NiveauEtude::class);
    }

    public function metier()
    {
        return $this->belongsTo(Metier::class);
    }


    public function formateurs()
    {
        return $this->belongsToMany(User::class, 'classe_formateur_matiere', 'matiere_id', 'formateur_id')
                    ->withPivot('classe_id')
                    ->withTimestamps();
    }
    
    public function classes()
    {
        return $this->belongsToMany(Classe::class, 'classe_formateur_matiere', 'matiere_id', 'classe_id')
                    ->withPivot('formateur_id')
                    ->withTimestamps();
    }

}
