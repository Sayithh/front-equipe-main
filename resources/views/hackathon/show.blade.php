<?php
use App\Utils\SessionHelpers;
?>

@extends('layouts.app')

@section('title', ' - Détails du Hackathon')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-center">{{ $hackathon->thematique }}</h1>
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Informations</h5>
                    <p><strong>Date :</strong> {{ \Carbon\Carbon::parse($hackathon->dateheuredebuth)->format('d/m/Y H:i') }} au {{ \Carbon\Carbon::parse($hackathon->dateheurefinh)->format('d/m/Y H:i') }}</p>
                    <p><strong>Lieu :</strong> {{ $hackathon->lieu }}, {{ $hackathon->ville }}</p>
                    <p><strong>Description :</strong> {{ $hackathon->objectifs }}</p>
                    <a href="{{ route('stats.hackathon', $hackathon->idhackathon) }}" class="btn btn-info mt-3">Voir les statistiques</a>
                </div>
            </div>

            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Commentaires</h5>
                    @if ($commentaires->isEmpty())
                        <p>Aucun commentaire pour ce hackathon.</p>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach ($commentaires as $commentaire)
                                <li class="list-group-item">
                                    <strong>{{ $commentaire->equipe->nomequipe }}</strong> ({{ \Carbon\Carbon::parse($commentaire->datecommentaire)->format('d/m/Y H:i') }}) :
                                    <p>{{ $commentaire->contenu }}</p>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    @if (SessionHelpers::isConnected())
                        <h5 class="mt-4">Ajouter un commentaire</h5>
                        <form action="{{ route('hackathon.addComment', $hackathon->idhackathon) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="contenu" class="form-label">Commentaire</label>
                                <textarea name="contenu" id="contenu" class="form-control" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            @if($hackathon->affiche && file_exists(public_path($hackathon->affiche)))
                <img src="{{ asset($hackathon->affiche) }}" class="img-fluid rounded mb-3" alt="Affiche de l'évènement">
            @else
                <img src="{{ asset('img/default-hackathon.png') }}" class="img-fluid rounded mb-3" alt="Image par défaut">
            @endif
        </div>
    </div>
</div>
@endsection