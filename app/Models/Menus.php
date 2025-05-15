<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menus extends Model
{
    use HasFactory;
    // Spécifier le nom de la table (au singulier)
        // Spécifier le nom de la table (au singulier)
    protected $table = 'menu';
    protected $fillable = [
        'name',
        'gastronomy',
        'price_per_person',
        'min_people',
        'description',
        'created_at',
    ];
}
