<?php

// app/Models/Printer.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Printer extends Model
{
    use HasFactory;

    // Atributos permitidos para asignación masiva
    protected $fillable = ['name', 'ip_address', 'toner_level'];
}
