<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Hackathon extends Model
{
    use HasFactory;

    protected $table = 'HACKATHON';
    protected $primaryKey = 'idhackathon';
    public $timestamps = false;

    protected $fillable = ['dateheuredebuth', 'dateheurefinh', 'lieu', 'ville', 'conditions', 'thematique', 'affiche', 'objectifs', 'idorganisateur'];

    protected $dates = ['dateheuredebuth', 'dateheurefinh'];

    public static function getActiveHackathon(): Hackathon
    {
        return Hackathon::where('dateheurefinh', '>', now())->orderBy('dateheuredebuth')->first();
    }

    public function organisateur()
    {
        return $this->belongsTo(Organisateur::class, 'idorganisateur');
    }

    public function equipes()
    {
        return $this->belongsToMany(Equipe::class, 'INSCRIRE', 'idhackathon', 'idequipe')->withPivot('dateinscription');
    }

    public function commentaires()
    {
        return $this->hasMany(Commentaire::class, 'idhackathon', 'idhackathon');
    }
}