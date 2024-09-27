<?php

namespace App\Http\Controllers;

use App\Models\Inscrire;
use App\Utils\SessionHelpers;
use Illuminate\Http\Request;

class HackathonController extends Controller
{
    // HackathonController.php

    // HackathonController.php

public function join(Request $request)
{
    // Vérification si l'équipe est connectée
    if (!SessionHelpers::isConnected()) {
        return redirect("/login")->withErrors(['errors' => "Vous devez être connecté pour accéder à cette page."]);
    }

    // Récupérer l'équipe connectée
    $equipe = SessionHelpers::getConnected();

    // Récupérer l'id du hackathon actif
    $idh = $request->get('idh');
    $hackathon = Hackathon::find($idh);

    // Vérification si le hackathon existe
    if (!$hackathon) {
        return redirect()->back()->withErrors(['error' => 'Le hackathon n\'existe pas.']);
    }

    // Vérification si la date d'inscription est dépassée
    if ($hackathon->dateheurefinh < now()) {
        return redirect()->back()->withErrors(['error' => 'La date limite d\'inscription est dépassée.']);
    }

    // Vérification si le nombre max d'équipes est atteint
    $nombreMaxEquipes = 10; // Exemple, à modifier selon ton projet
    $nombreEquipesInscrites = Inscrire::where('idhackathon', $idh)->count();

    if ($nombreEquipesInscrites >= $nombreMaxEquipes) {
        return redirect()->back()->withErrors(['error' => 'Le nombre maximum d\'équipes est atteint.']);
    }

    // Vérification si l'équipe est déjà inscrite
    $inscriptionExiste = Inscrire::where('idequipe', $equipe->idequipe)
        ->where('idhackathon', $idh)
        ->exists();

    if ($inscriptionExiste) {
        return redirect()->back()->withErrors(['error' => 'Vous êtes déjà inscrit à ce hackathon.']);
    }

    // Inscription de l'équipe
    $inscription = new Inscrire();
    $inscription->idhackathon = $idh;
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
