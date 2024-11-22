@extends('layouts.app')

@section('title', ' - Bienvenue')

@section('custom-css')
    <style>
        /* Image de fond et mise en page */


        .bannerHome {
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            background: rgba(255, 255, 255, 0.9);
        }

        .card-header {
            background-color: rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .card-title {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }

        .btn-primary, .btn-success {
            border-radius: 50px;
            font-weight: bold;
            padding: 10px 20px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover, .btn-success:hover {
            background-color: #0056b3;
            color: white;
        }

        .team-list .card {
            margin-bottom: 20px;
        }

        .team-list .card-title {
            font-size: 18px;
            color: #000;
        }

        /* Modal pour les membres */
        .modal-content {
            border-radius: 15px;
        }

        .modal-title {
            font-size: 20px;
            font-weight: bold;
        }

        /* Boutons actions */
        .button-home {
            font-weight: bold;
            text-transform: uppercase;
            color: white;
            background: #4285f4;
            border: none;
            padding: 10px 15px;
            margin: 5px;
            border-radius: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .button-home:hover {
            background-color: #1a73e8;
            transform: translateY(-3px);
        }
    </style>
@endsection

@section('content')
<div class="container py-4">
    <div class="bannerHome mb-5">
        <h1>Bienvenue sur Hackat'innov 👋</h1>
        <p>Rejoignez un hackathon ou découvrez les équipes participantes !</p>
    </div>

    @if($hackathon)
        <div class="row">
            <!-- Section Information Hackathon -->
            <div class="col-md-4">
                @if($hackathon->affiche && file_exists(public_path($hackathon->affiche)))
                    <img src="{{ asset($hackathon->affiche) }}" class="img-fluid rounded mb-3 shadow" alt="Affiche de l'évènement">
                @else
                    <img src="{{ asset('img/default-hackathon.png') }}" class="img-fluid rounded mb-3 shadow" alt="Image par défaut">
                @endif
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Informations</h5>
                        <p><strong>Date :</strong> {{ \Carbon\Carbon::parse($hackathon->dateheuredebuth)->format("d/m/Y H:i") }}
                            au {{ \Carbon\Carbon::parse($hackathon->dateheurefinh)->format("d/m/Y H:i") }}</p>
                        <p><strong>Lieu :</strong> {{ $hackathon->ville }}</p>
                        <p><strong>Organisateur :</strong> {{ $organisateur->nom }} {{ $organisateur->prenom }}</p>
                    </div>
                </div>
            </div>

            <!-- Section Équipes Participantes -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0 text-center">Équipes participantes</h3>
                    </div>
                    <div class="card-body team-list">
                        @if($participants && count($participants) > 0)
                            <div class="row">
                                @foreach($participants as $equipe)
                                    <div class="col-md-6">
                                        <div class="card shadow-sm">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $equipe->nomequipe }}</h5>
                                                @if(\App\Utils\SessionHelpers::isConnected())
                                                    <button class="btn btn-outline-primary btn-sm w-100 mt-2" 
                                                            onclick="showMembres('{{ $equipe->idequipe }}', '{{ $equipe->nomequipe }}')"
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#membresModal">
                                                        <i class="fas fa-users me-2"></i>Voir les membres
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-info text-center">Aucune équipe participante pour ce hackathon.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info text-center">Aucun hackathon n'est actuellement actif.</div>
    @endif
</div>

<!-- Modal pour afficher les membres -->
<div class="modal fade" id="membresModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Membres de l'équipe "<span id="equipeNom"></span>"
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group" id="membresList">
                    <li class="list-group-item text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Chargement...</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function showMembres(idequipe, nomEquipe) {
    const listElement = document.getElementById('membresList');
    const titleElement = document.getElementById('equipeNom');

    titleElement.textContent = nomEquipe;
    listElement.innerHTML = `
        <li class="list-group-item text-center">
            <div class="spinner-border spinner-border-sm text-primary" role="status">
                <span class="visually-hidden">Chargement...</span>
            </div>
        </li>`;

    fetch(`/api/membre/${idequipe}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Erreur réseau : ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                listElement.innerHTML = `<li class="list-group-item text-danger">${data.error}</li>`;
            } else {
                listElement.innerHTML = data.map(membre => `
                    <li class="list-group-item">
                        <i class="fas fa-user me-2"></i> ${membre.prenom} ${membre.nom}
                    </li>
                `).join('');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            listElement.innerHTML = `<li class="list-group-item text-danger">Une erreur est survenue.</li>`;
        });
}
</script>
@endsection
