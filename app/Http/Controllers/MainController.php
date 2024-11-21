<?php
namespace App\Http\Controllers;

use App\Models\Equipe;
use App\Models\Hackathon;
use App\Utils\SessionHelpers;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function home()
    {
        $hackathon = Hackathon::getActiveHackathon();
        $showButtons = true;
        $message = '';

        if ($hackathon) {
            $nbEquipes = Equipe::getEquipesInHackhon($hackathon->idhackathon)->count();
            if ($nbEquipes >= $hackathon->nbequipemax) {
                $showButtons = false;
                $message = "Le nombre maximum d'équipes est atteint.";
            }

            // Récupérer les équipes participantes
            $participants = Equipe::getEquipesInHackhon($hackathon->idhackathon);
        } else {
            $participants = collect();
        }

        // Passer les données à la vue
        return view('main.home', [
            'hackathon' => $hackathon,
            'showButtons' => $showButtons,
            'message' => $message,
            'organisateur' => $hackathon ? $hackathon->organisateur : null,
            'participants' => $participants,
        ]);
    }

    public function about()
    {
        return view('main.about');
    }
}