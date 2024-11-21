<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    use HasFactory;

    protected $table = 'COMMENTAIRE';
    protected $primaryKey = 'idcommentaire';
    public $timestamps = false;

    protected $fillable = ['idhackathon', 'idequipe', 'contenu', 'datecommentaire'];

    public function equipe()
    {
        return $this->belongsTo(Equipe::class, 'idequipe', 'idequipe');
    }

    public function hackathon()
    {
        return $this->belongsTo(Hackathon::class, 'idhackathon', 'idhackathon');
    }
}