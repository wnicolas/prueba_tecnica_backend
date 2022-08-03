<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partido extends Model
{
    use HasFactory;
    protected $table = "partidos";
    protected $fillable = [
        "id_local",
        "id_visitante",
        "goles_local",
        "goles_visitante",
        "fecha",
        "id_cuadrangular"
    ];
}
