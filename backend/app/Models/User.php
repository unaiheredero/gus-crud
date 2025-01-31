<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens; // Add this line

class User extends Model
{
    use HasFactory, HasApiTokens;
    public $timestamps = false;
    protected $fillable = [
        'name',
        'email',
        'passHash',
        'isAdmin',
        'isBanned',
    ];

    // Hide password field in response
    protected $hidden = [
        'passHash',
    ];
}


// <?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

// class User extends Model
// {
//     use HasFactory;

//     // Especificamos la tabla que estamos utilizando
//     protected $table = 'User'; 

//     // Atributos que se pueden asignar masivamente
//     protected $fillable = [
//         'id', 'name', 'email', 'pass_hash', 'is_admin', 'is_banned'
//     ];

//     // No queremos que Laravel asigne automáticamente el campo 'id' (porque es un UUID y no es auto incrementable)
//     public $incrementing = false;

//     // El tipo de la columna 'id' es string
//     protected $keyType = 'string';

//     // Para que Laravel no intente manejar las marcas de tiempo automáticamente
//     public $timestamps = false;
// }
