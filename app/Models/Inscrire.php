<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscrire extends Model
{
    use HasFactory;

    protected $table = 'INSCRIRE';
    public $timestamps = false;

    protected $fillable = ['idhackathon', 'idequipe', 'dateinscription', 'datedesincription'];

    public $incrementing = false;
    protected $primaryKey = null;

    public function getKeyForSaveQuery()
    {
        $query = $this->newQueryWithoutScopes();

        foreach ($this->getAttributes() as $key => $value) {
            if (in_array($key, ['idhackathon', 'idequipe'])) {
                $query->where($key, '=', $value);
            }
        }

        return $query;
    }
}