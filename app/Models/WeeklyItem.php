<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyItem extends Model
{
    use HasFactory;

    protected $table = 'weekly_items';

    protected $fillable = [
        'code',
        'nom',
        'description',
        'prix',
        'categorie',
        'vegetarien',
        'epice',
    ];

    protected $casts = [
        'prix' => 'float',
        'vegetarien' => 'boolean',
        'epice' => 'boolean',
    ];
}
