<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipe extends Model
{
    use HasFactory;

    protected $table = 'EQUIPE';
    protected $primaryKey = 'idequipe';
    public $timestamps = false;

    protected $fillable = ['nomequipe', 'lienprototype', 'login', 'password'];

    public function membres()
    {
        return $this->hasMany(Membre::class, 'idequipe', 'idequipe');
    }

    public function hackathons()
    {
        return $this->belongsToMany(Hackathon::class, 'INSCRIRE', 'idequipe', 'idhackathon')->withPivot('dateinscription');
    }

    public function commentaires()
    {
        return $this->hasMany(Commentaire::class, 'idequipe', 'idequipe');
    }

    public static function getEquipesInHackhon($idhackathon)
    {
        return self::whereHas('hackathons', function ($query) use ($idhackathon) {
            $query->where('INSCRIRE.idhackathon', $idhackathon);
        })->get();
    }
}