<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Administrateur extends Authenticatable
{
    use Notifiable;

    protected $table = 'ADMINISTRATEUR';
    protected $primaryKey = 'idadministrateur';

    protected $fillable = [
        'nom', 'prenom', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}