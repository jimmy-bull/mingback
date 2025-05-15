<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class SubMenu extends Model
{
    use HasFactory;

    protected $table = 'sub_menu';

    // If you don't have standard timestamps (created_at, updated_at)
    public $timestamps = false;

    // Define which fields can be mass-assigned
    protected $fillable = [
        'category',
        'gastronomy',
        'name',
        'price',
        'description',
        'image_path',
        // Include any other fields from your table
    ];
}
