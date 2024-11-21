<?php

namespace App\Http\Controllers;

use App\Models\Equipe;
use App\Models\Hackathon;
use App\Models\Inscrire;
use App\Models\Membre;
use App\Utils\EmailHelpers;
use App\Utils\SessionHelpers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class EquipeController extends Controller
{
    /**
     * Affiche la page de connexion.
     *
     * L'équipe se connecte avec son email et son mot de passe.
     * Le formulaire soumet les données à la route connect (POST).
     */
    public function login()
    {
        return view('equipe.login');
    }

    /**
     * Méthode de connexion de l'équipe.
     * Vérifie les informations de connexion et connecte l'équipe.
     */
    public function connect(Request $request)
    {
        $validated = $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required',
            ],
            [
                'required' => 'Le champ :attribute est obligatoire.',
                'email' => 'Le champ :attribute doit être une adresse email valide.',
            ],
            [
                'email' => 'email',
                'password' => 'mot de passe',
            ]
        );

        // Récupération de l'équipe avec l'email fourni
        $equipe = Equipe::where('login', $validated['email'])->first();

        // Si l'équipe n'existe pas, on redirige vers la page de connexion avec un message d'erreur
        if (!$equipe) {
            return redirect("/login")->withErrors(['errors' => "Aucune équipe n'a été trouvée avec cet email."]);
        }

        // Si le mot de passe est incorrect, on redirige vers la page de connexion avec un message d'erreur
        // Le message d'erreur est volontairement vague pour des raisons de sécurité
        // En cas d'erreur, on ne doit pas donner d'informations sur l'existence ou non de l'email
        if (!password_verify($validated['password'], $equipe->password)) {
            return redirect("/login")->withErrors(['errors' => "Aucune équipe n'a été trouvée avec cet email."]);
        }

        // Connexion de l'équipe
        SessionHelpers::login($equipe);

        // Redirection vers la page de profil de l'équipe
        return redirect("/me");
    }

    /**
     * Méthode de création d'une équipe.
     * Affiche le formulaire de création d'équipe.
     */
    public function create(Request $request)
    {
        // Si l'équipe est déjà connectée, on la redirige vers sa page de profil
        if (SessionHelpers::isConnected()) {
            return redirect("/me");
        }

        // Si le formulaire n'a pas été soumis, on affiche le formulaire de création d'équipe
        if (!$request->isMethod('post')) {
            return view('equipe.create', []);
        }

        // Sinon, on traite les données du formulaire
        // Validation des données, on vérifie que les champs sont corrects.
        $request->validate(
            [
                'nom' => 'required|string|max:255',
                'lien' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:EQUIPE,login',
                'password' => 'required|string|min:8',
            ],
            [
                'required' => 'Le champ :attribute est obligatoire.',
                'string' => 'Le champ :attribute doit être une chaîne de caractères.',
                'max' => 'Le champ :attribute ne peut pas dépasser :max caractères.',
                'email' => 'Le champ :attribute doit être une adresse email valide.',
                'unique' => 'Cette adresse :attribute est déjà utilisée.',
                'min' => 'Le champ :attribute doit contenir au moins :min caractères.',
            ],
            [
                'nom' => 'nom',
                'lien' => 'lien',
                'email' => 'email',
                'password' => 'mot de passe',
            ]
        );

        // Récupération du hackathon actif
        $hackathon = Hackathon::getActiveHackathon();

        // Si aucun hackathon n'est actif, on redirige vers la page de création d'équipe avec un message d'erreur
        if (!$hackathon) {
            return redirect("/create-team")->withErrors(['errors' => "Aucun hackathon n'est actif pour le moment. Veuillez réessayer plus tard."]);
        }

        try {
            // Création de l'équipe
            $equipe = new Equipe();
            $equipe->nomequipe = $request->input('nom');
            $equipe->lienprototype = $request->input('lien');
            $equipe->login = $request->input('email');
            $equipe->password = bcrypt($request->input('password'));
            $equipe->save();

            // Envoi d'un email permettant de confirmer l'inscription
            EmailHelpers::sendEmail($equipe->login, "Inscription de votre équipe", "email.create-team", ['equipe' => $equipe]);

            // Connexion de l'équipe
            SessionHelpers::login($equipe);

            // L'équipe rejoindra le hackathon actif.
            // On crée une inscription pour l'équipe (table INSCRIRE)
            Inscrire::create([
                'idequipe' => $equipe->idequipe,
                'idhackathon' => $hackathon->idhackathon,
                'dateinscription' => date('Y-m-d H:i:s'),
            ]);

            // Redirection vers la page de profil de l'équipe avec un message de succès
            return redirect("/me")->with('success', "Votre équipe a bien été créée. Vérifiez votre boîte mail pour confirmer votre inscription.");
        } catch (\Exception $e) {
            // Redirection vers la page de création d'équipe avec un message d'erreur
            return redirect("/create-team?idh=" . $request->idh)->withErrors(['errors' => "Une erreur est survenue lors de la création de votre équipe."]);
        }

    }

    /**
     * Méthode de déconnexion, vide la session et redirige vers la page d'accueil.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        SessionHelpers::logout();
        return redirect()->route('home');
    }


    /**
     * Méthode de visualisation de la page de profil de l'équipe.
     * Permet de voir les informations de l'équipe, les membres, et d'ajouter des membres.
     */
    public function me()
    {
        // Si l'équipe n'est pas connectée, on la redirige vers la page de connexion
        if (!SessionHelpers::isConnected()) {
            return redirect("/login");
        }

        // Récupération de l'équipe connectée
        $equipe = SessionHelpers::getConnected();

        // Récupération des membres de l'équipe
        $membres = $equipe->membres;

        // Récupération du hackathon ou l'équipe est inscrite
        $hackathon = $equipe->hackathons()->first();

        return view('equipe.me', ['connected' => $equipe, 'membres' => $membres, 'hackathon' => $hackathon]);
    }

    /**
     * Méthode d'ajout d'un membre à l'équipe.
     */
    public function addMembre(Request $request)
    {
        if (!SessionHelpers::isConnected()) {
            return response()->json(['success' => false, 'message' => 'Non autorisé'], 401);
        }

        $validated = $request->validate([
            'nom' => 'required|string|max:128',
            'prenom' => 'required|string|max:128',
            'email' => 'required|email|max:255|unique:MEMBRE,email',
            'telephone' => 'nullable|string|max:20',
            'datenaissance' => 'nullable|date',
            'lienportfolio' => 'nullable|url|max:255'
        ]);

        try {
            $equipe = SessionHelpers::getConnected();

            $membre = new Membre();
            $membre->nom = $validated['nom'];
            $membre->prenom = $validated['prenom'];
            $membre->email = $validated['email'];
            $membre->telephone = $validated['telephone'];
            $membre->datenaissance = $validated['datenaissance'];
            $membre->lienportfolio = $validated['lienportfolio'];
            $membre->idequipe = $equipe->idequipe;
            $membre->save();

            // Envoi email
            EmailHelpers::sendEmail(
                $membre->email,
                "Bienvenue dans l'équipe",
                "email.membre-welcome",
                ['membre' => $membre, 'equipe' => $equipe]
            );

            return response()->json([
                'success' => true,
                'message' => 'Membre ajouté avec succès',
                'membre' => $membre
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur ajout membre: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'ajout du membre'
            ], 500);
        }
    }

    // Méthode de suppression d'un membre
    public function deleteMembre($id)
    {
        if (!SessionHelpers::isConnected()) {
            return response()->json(['error' => 'Non autorisé'], 401);
        }

        $membre = Membre::find($id);
        if (!$membre) {
            return response()->json([
                'success' => false,
                'message' => 'Le membre n\'existe pas',
            ], 404);
        }

        try {
            $membre->delete();

            return response()->json([
                'success' => true,
                'message' => 'Membre supprimé avec succès',
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur suppression membre: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression',
            ], 500);
        }
    }

    public function showMembers()
{
    if (!SessionHelpers::isConnected()) {
        return redirect('/login');
    }

    $equipe = SessionHelpers::getConnected();
    $membres = Membre::where('idequipe', $equipe->idequipe)->get();

    return view('me', compact('membres')); // Vérifiez le nom de la vue ici
}
// Affiche le formulaire d'édition du profil
public function editProfileForm()
{
    if (!SessionHelpers::isConnected()) {
        return redirect('/login');
    }

    $equipe = SessionHelpers::getConnected();
    return view('equipe.edit-profile', compact('equipe'));
}

// Met à jour le profil de l'équipe
public function updateProfile(Request $request)
{
    if (!SessionHelpers::isConnected()) {
        return redirect('/login');
    }

    $validated = $request->validate([
        'nom' => 'required|string|max:255',
        'lien' => 'nullable|string|max:255',
        'email' => 'required|email|max:255|unique:EQUIPE,login,' . SessionHelpers::getConnected()->idequipe . ',idequipe',
        'password' => 'nullable|string|min:8|confirmed',
    ], [
        'required' => 'Le champ :attribute est obligatoire.',
        'string' => 'Le champ :attribute doit être une chaîne de caractères.',
        'max' => 'Le champ :attribute ne peut pas dépasser :max caractères.',
        'email' => 'Le champ :attribute doit être une adresse email valide.',
        'unique' => 'Cette adresse :attribute est déjà utilisée.',
        'min' => 'Le champ :attribute doit contenir au moins :min caractères.',
        'confirmed' => 'Les mots de passe ne correspondent pas.',
    ]);

    try {
        $equipe = SessionHelpers::getConnected();
        $equipe->nomequipe = $validated['nom'];
        $equipe->lienprototype = $validated['lien'];
        $equipe->login = $validated['email'];

        if (!empty($validated['password'])) {
            $equipe->password = Hash::make($validated['password']);
        }

        $equipe->save();

        return redirect()->route('me')->with('success', 'Profil mis à jour avec succès');
    } catch (\Exception $e) {
        Log::error('Erreur mise à jour profil: ' . $e->getMessage());
        return redirect()->route('edit-profile')->withErrors(['errors' => 'Erreur lors de la mise à jour du profil']);
    }
}

/**
     * Méthode pour quitter un hackathon.
     */
    public function quitHackathon(Request $request)
    {
        if (!SessionHelpers::isConnected()) {
            return redirect('/login')->withErrors(['errors' => 'Vous devez être connecté pour quitter un hackathon.']);
        }

        $equipe = SessionHelpers::getConnected();
        $hackathon = Hackathon::find($request->input('idhackathon'));

        if (!$hackathon) {
            return redirect()->back()->withErrors(['errors' => 'Ce hackathon n\'existe pas.']);
        }

        $inscription = Inscrire::where('idequipe', $equipe->idequipe)
            ->where('idhackathon', $hackathon->idhackathon)
            ->first();

        if (!$inscription) {
            return redirect()->back()->withErrors(['errors' => 'Vous n\'êtes pas inscrit à ce hackathon.']);
        }

        $inscription->datedesincription = now();
        $inscription->save();

        return redirect()->route('home')->with('success', 'Vous avez quitté le hackathon avec succès.');
    }
    public function downloadTeamData(Request $request)
    {
        if (!SessionHelpers::isConnected()) {
            return redirect('/login')->withErrors(['errors' => 'Vous devez être connecté pour télécharger les données.']);
        }

        $equipe = SessionHelpers::getConnected();

        // Récupérer les données de l'équipe
        $data = [
            'equipe' => $equipe,
            'membres' => $equipe->membres,
            'hackathons' => $equipe->hackathons,
            'inscriptions' => Inscrire::where('idequipe', $equipe->idequipe)->get(),
        ];

        // Générer le fichier JSON
        $json = json_encode($data, JSON_PRETTY_PRINT);
        $fileName = 'team_data_' . $equipe->idequipe . '.json';
        Storage::disk('local')->put($fileName, $json);

        // Envoyer l'email avec le fichier JSON en pièce jointe
        EmailHelpers::sendEmail(
            $equipe->login,
            'Téléchargement des données de l\'équipe',
            'email.team-data',
            ['equipe' => $equipe],
            storage_path('app/' . $fileName)
        );

        return redirect()->back()->with('success', 'Votre demande de téléchargement des données a été initiée. Vous recevrez un email avec les données sous peu.');
    }
}
