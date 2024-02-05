<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class materiala_erabili extends Model
{
    protected $table = 'materiala_erabili';
    public $timestamps = false;
    protected $fillable = [
        // Agrega otras columnas que permitas en la asignación masiva, si las hay
        'eguneratze_data',
    ];
}
