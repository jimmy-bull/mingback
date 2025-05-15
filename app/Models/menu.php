<?php

// app/Models/Menu.php
// declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
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
