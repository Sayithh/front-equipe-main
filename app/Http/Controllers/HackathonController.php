<?php

namespace App\Http\Controllers;

use App\Models\Inscrire;
use App\Utils\SessionHelpers;
use App\Utils\EmailHelpers;
use App\Models\Hackathon;
use App\Models\Commentaire;
use Illuminate\Http\Request;

class HackathonController extends Controller
{
    public function index()
    {
        $hackathonsPasses = Hackathon::where('dateheurefinh', '<', now())->orderBy('dateheuredebuth', 'desc')->get();
        $hackathonsFuturs = Hackathon::where('dateheuredebuth', '>', now())->orderBy('dateheuredebuth', 'asc')->get();

        return view('hackathon.index', compact('hackathonsPasses', 'hackathonsFuturs'));
    }

    public function show($id)
    {
        $hackathon = Hackathon::findOrFail($id);
        $commentaires = $hackathon->commentaires()->with('equipe')->get();

        return view('hackathon.show', compact('hackathon', 'commentaires'));
    }

    public function addComment(Request $request, $id)
    {
        if (!SessionHelpers::isConnected()) {
            return redirect('/login')->withErrors(['errors' => 'Vous devez être connecté pour ajouter un commentaire.']);
        }

        $request->validate([
            'contenu' => 'required|string|max:1000',
        ]);

        $equipe = SessionHelpers::getConnected();

        Commentaire::create([
            'idhackathon' => $id,
            'idequipe' => $equipe->idequipe,
            'contenu' => $request->input('contenu'),
            'datecommentaire' => now(),
        ]);

        return redirect()->route('hackathon.show', $id)->with('success', 'Commentaire ajouté avec succès.');
    }

    public function join(Request $request)
    {
        if (!SessionHelpers::isConnected()) {
            return redirect("/login")->withErrors([
                'error' => 'Vous devez être connecté pour rejoindre un hackathon.'
            ]);
        }

        $equipe = SessionHelpers::getConnected();
        $hackathon = Hackathon::find($request->get('idh'));
        if (!$hackathon) {
            return redirect()->back()->withErrors([
                'error' => 'Ce hackathon n\'existe pas ou n\'est plus disponible.'
            ]);
        }
    
        if ($hackathon->dateheurefinh < now()) {
            return redirect()->back()->withErrors([
                'error' => 'La date limite d\'inscription est dépassée. Le hackathon a commencé le ' . 
                date('d/m/Y', strtotime($hackathon->dateheuredebuth))
            ]);
        }
    
        $nombreEquipesInscrites = Inscrire::where('idhackathon', $hackathon->idhackathon)->count();
        
        if ($nombreEquipesInscrites >= $hackathon->nbequipemax) {
            return redirect()->back()->withErrors([
                'error' => 'Le nombre maximum d\'équipes (' . $hackathon->nbequipemax . ') est atteint pour ce hackathon.'
            ]);
        }
    
        $inscriptionExiste = Inscrire::where('idequipe', $equipe->idequipe)
            ->where('idhackathon', $hackathon->idhackathon)
            ->exists();
    
        if ($inscriptionExiste) {
            return redirect()->back()->withErrors([
                'error' => 'Votre équipe est déjà inscrite à ce hackathon.'
            ]);
        }
    
    // Inscription de l'équipe
    $inscription = new Inscrire();
    $inscription->idhackathon = $hackathon->idhackathon;
    $inscription->idequipe = $equipe->idequipe;
    $inscription->dateinscription = now();
    $inscription->save();

    // Envoi de l'email de confirmation
    EmailHelpers::sendEmail($equipe->login, "Confirmation d'inscription", "email.inscription", [
        'equipe' => $equipe,
        'hackathon' => $hackathon
    ]);

    return redirect("/me")->with('success', 'Inscription réussie et email de confirmation envoyé.');
}

    
}
