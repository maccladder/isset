<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Total extends Model
{
    use HasFactory;

    protected $fillable = [
        'time',
        'nbre_tf_impactes',
        'nbre_inscription',
        'nbre_tf_crees',
    ];
}
