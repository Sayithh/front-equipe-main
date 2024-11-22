<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membre extends Model
{
    use HasFactory;

    protected $table = 'MEMBRE';
    protected $primaryKey = 'idmembre';
    public $timestamps = false;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'datenaissance',
        'lienportfolio',
        'idequipe'
    ];

    public function equipe()
    {
        return $this->belongsTo(Equipe::class, 'idequipe', 'idequipe');
    }
}