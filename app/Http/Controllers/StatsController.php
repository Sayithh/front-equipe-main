<?php
namespace App\Http\Controllers;

use App\Models\Equipe;
use App\Models\Hackathon;
use App\Models\Membre;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function hackathonStats($id)
    {
        $hackathon = Hackathon::findOrFail($id);
        $equipes = $hackathon->equipes()->count();
        $participants = Membre::whereIn('idequipe', $hackathon->equipes()->pluck('EQUIPE.idequipe'))->count();

        return view('stats.hackathon', [
            'hackathon' => $hackathon,
            'equipes' => $equipes,
            'participants' => $participants,
        ]);
    }

    public function publicStats()
    {
        $totalHackathons = Hackathon::count();
        $totalEquipes = Equipe::count();
        $totalMembres = Membre::count();

        return view('stats.public', [
            'totalHackathons' => $totalHackathons,
            'totalEquipes' => $totalEquipes,
            'totalMembres' => $totalMembres,
        ]);
    }
}