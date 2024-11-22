<?php

namespace App\Http\Controllers;

use App\Models\Equipe;
use App\Models\Hackathon;
use App\Models\Inscrire;
use App\Models\Membre;
use App\Utils\EmailHelpers;
use App\Utils\SessionHelpers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class EquipeController extends Controller
{
    public function login()
    {
        return view('equipe.login');
    }

    public function logout()
    {
        SessionHelpers::logout();
        return redirect()->route('home');
    }

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

        $equipe = Equipe::where('login', $validated['email'])->first();

        if (!$equipe) {
            return redirect("/login")->withErrors(['errors' => "Aucune équipe n'a été trouvée avec cet email."]);
        }

        if (!password_verify($validated['password'], $equipe->password)) {
            return redirect("/login")->withErrors(['errors' => "Aucune équipe n'a été trouvée avec cet email."]);
        }

        SessionHelpers::login($equipe);

        return redirect("/me");
    }

    public function create(Request $request)
    {
        if (SessionHelpers::isConnected()) {
            return redirect("/me");
        }

        if (!$request->isMethod('post')) {
            return view('equipe.create', []);
        }

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

        $hackathon = Hackathon::getActiveHackathon();

        if (!$hackathon) {
            return redirect("/create-team")->withErrors(['errors' => "Aucun hackathon n'est actif pour le moment. Veuillez réessayer plus tard."]);
        }

        try {
            $equipe = new Equipe();
            $equipe->nomequipe = $request->input('nom');
            $equipe->lienprototype = $request->input('lien');
            $equipe->login = $request->input('email');
            $equipe->password = bcrypt($request->input('password'));
            $equipe->save();

            EmailHelpers::sendEmail($equipe->login, "Inscription de votre équipe", "email.create-team", ['equipe' => $equipe]);

            SessionHelpers::login($equipe);

            Inscrire::create([
                'idequipe' => $equipe->idequipe,
                'idhackathon' => $hackathon->idhackathon,
                'dateinscription' => date('Y-m-d H:i:s'),
            ]);

            return redirect("/me")->with('success', "Votre équipe a bien été créée. Vérifiez votre boîte mail pour confirmer votre inscription.");
        } catch (\Exception $e) {
            return redirect("/create-team?idh=" . $request->idh)->withErrors(['errors' => "Une erreur est survenue lors de la création de votre équipe."]);
        }
    }

    public function me()
    {
        if (!SessionHelpers::isConnected()) {
            return redirect("/login");
        }

        $equipe = SessionHelpers::getConnected();
        $membres = $equipe->membres;
        $hackathon = $equipe->hackathons()->first();

        return view('equipe.me', ['connected' => $equipe, 'membres' => $membres, 'hackathon' => $hackathon]);
    }

    public function showMembers()
    {
        if (!SessionHelpers::isConnected()) {
            return redirect('/login')->withErrors('Veuillez vous connecter.');
        }

        $equipe = SessionHelpers::getConnected();
        $membres = $equipe->membres;

        return view('equipe.me', compact('membres', 'equipe'));
    }

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
            'lienportfolio' => 'nullable|url|max:255',
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

            Mail::send('emails.membre_welcome', ['membre' => $membre, 'equipe' => $equipe], function ($message) use ($membre) {
                $message->to($membre->email)->subject('Bienvenue dans l\'équipe');
            });

            return response()->json([
                'success' => true,
                'message' => 'Membre ajouté avec succès',
                'membre' => $membre,
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erreur lors de l\'ajout du membre'], 500);
        }
    }

    public function deleteMembre(Request $request)
    {
        if (!SessionHelpers::isConnected()) {
            return response()->json(['success' => false, 'message' => 'Non autorisé'], 401);
        }

        $membre = Membre::find($request->idmembre);

        if (!$membre || $membre->idequipe != SessionHelpers::getConnected()->idequipe) {
            return response()->json(['success' => false, 'message' => 'Membre introuvable ou non autorisé'], 404);
        }

        try {
            $membre->delete();
            return response()->json(['success' => true, 'message' => 'Membre supprimé avec succès']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erreur lors de la suppression'], 500);
        }
    }

    public function editProfileForm()
    {
        if (!SessionHelpers::isConnected()) {
            return redirect('/login');
        }

        $equipe = SessionHelpers::getConnected();
        return view('equipe.edit-profile', compact('equipe'));
    }

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

        try {
            $equipe = SessionHelpers::getConnected();

            $data = [
                'equipe' => [
                    'id' => $equipe->idequipe,
                    'nom' => $equipe->nomequipe,
                    'email' => $equipe->login,
                    'lienprototype' => $equipe->lienprototype,
                    'date_creation' => $equipe->created_at,
                ],
                'membres' => $equipe->membres()->get()->map(function ($membre) {
                    return [
                        'id' => $membre->id,
                        'nom' => $membre->nom,
                        'prenom' => $membre->prenom,
                        'email' => $membre->email,
                        'telephone' => $membre->telephone,
                        'date_naissance' => $membre->datenaissance,
                    ];
                }),
                'hackathons' => $equipe->hackathons()->get()->map(function ($hackathon) {
                    return [
                        'id' => $hackathon->idhackathon,
                        'thematique' => $hackathon->thematique,
                        'date_debut' => $hackathon->dateheuredebuth,
                        'date_fin' => $hackathon->dateheurefinh,
                    ];
                }),
                'inscriptions' => Inscrire::where('idequipe', $equipe->idequipe)->get()->map(function ($inscription) {
                    return [
                        'hackathon_id' => $inscription->idhackathon,
                        'date_inscription' => $inscription->dateinscription,
                        'date_desinscription' => $inscription->datedesincription,
                    ];
                }),
            ];

            $jsonContent = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            if ($jsonContent === false) {
                throw new \Exception('Erreur lors de la génération du fichier JSON.');
            }

            $fileName = 'team_data_' . $equipe->idequipe . '.json';
            $filePath = storage_path('app/' . $fileName);

            file_put_contents($filePath, $jsonContent);

            if (!file_exists($filePath)) {
                throw new \Exception('Le fichier JSON n\'a pas été généré correctement.');
            }

            EmailHelpers::sendEmail(
                $equipe->login,
                'Téléchargement des données de l\'équipe',
                'email.team-data',
                ['equipe' => $equipe],
                $filePath
            );

            return redirect()->back()->with('success', 'Votre demande de téléchargement des données a été initiée. Vous recevrez un email avec les données sous peu.');

        } catch (\Exception $e) {
            Log::error('Erreur lors du téléchargement des données : ' . $e->getMessage());
            return redirect()->back()->withErrors(['errors' => 'Une erreur est survenue lors du traitement de votre demande.']);
        }
    }
}
