<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class citas extends Model
{
    use HasFactory;
    public function Pacientes()
    {
        return $this->belongsToMany(Pacientes::class);
    }
}
