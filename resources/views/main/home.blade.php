
@php
    use App\Utils\SessionHelpers;
@endphp

@extends('layouts.app')

@section('title', ' - Bienvenue')

    <link href="../css/home.css" rel="stylesheet"/>
    <style>
        body {
            color: #0000;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            border-radius: 15px 15px 0 0;
        }
        .card-body {
            padding: 20px;
        }
        .btn-primary, .btn-success {
            border-radius: 50px;
        }
        .modal-content {
            border-radius: 15px;
        }
    </style>

@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-center text-white">Bienvenue sur Hackat'innov 👋</h1>
    <div class="container py-4">
        @if($hackathon)
            <div class="row">
                <!-- Section information hackathon -->
                <div class="col-md-4">
                    @if($hackathon->affiche && file_exists(public_path($hackathon->affiche)))
                        <img src="{{ asset($hackathon->affiche) }}" class="img-fluid rounded mb-3" alt="Affiche de l'évènement">
                    @else
                        <img src="{{ asset('img/default-hackathon.png') }}" class="img-fluid rounded mb-3" alt="Image par défaut">
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

                <!-- Section équipes participantes -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="mb-0">Équipes participantes</h3>
                            @if($showButtons)
                                <div class="d-flex gap-2">
                                    <a class="btn btn-primary btn-sm" href="/join?idh={{ $hackathon->idhackathon }}">Rejoindre</a>
                                    <a class="btn btn-success btn-sm" href="{{ route('create-team') }}">Créer mon équipe</a>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            @if($participants && count($participants) > 0)
                                <div class="row g-3">
                                    @foreach($participants as $equipe)
                                        <div class="col-md-6">
                                            <div class="card h-100 shadow-sm">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $equipe->nomequipe }}</h5>
                                                    @if(SessionHelpers::isConnected())
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
                                <div class="alert alert-info">Aucune équipe participante pour ce hackathon.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-info">Aucun hackathon n'est actuellement actif.</div>
        @endif
    </div>
</div>

<!-- Modal pour afficher les membres -->
<div class="modal fade" id="membresModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-users me-2"></i>
                    Membres de l'équipe "<span id="equipeNom"></span>"
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group list-group-flush" id="membresList">
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
        .then(async response => {
            if (!response.ok) {
                throw new Error('Erreur réseau');
            }
            const data = await response.json();
            if (Array.isArray(data)) {
                return data;
            }
            throw new Error('Format de données invalide');
        })
        .then(membres => {
            if (membres.length > 0) {
                listElement.innerHTML = membres
                    .map(membre => `
                        <li class="list-group-item d-flex align-items-center">
                            <i class="fas fa-user me-2"></i>
                            <span>${membre.prenom} ${membre.nom}</span>
                        </li>
                    `)
                    .join('');
            } else {
                listElement.innerHTML = `
                    <li class="list-group-item text-center text-muted">
                        <i class="fas fa-info-circle me-2"></i>
                        Aucun membre dans cette équipe
                    </li>`;
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            listElement.innerHTML = `
                <li class="list-group-item text-center text-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    Erreur lors du chargement des membres
                </li>`;
        });
}
</script>
@endsection