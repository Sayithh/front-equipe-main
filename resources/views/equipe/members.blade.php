@extends('layouts.app')

@section('title', ' - Membres de l\'équipe')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h2>Équipe : {{ $equipe->nomequipe }}</h2>
            @if($hackathon)
                <p class="mb-0">Participant au hackathon : {{ $hackathon->thematique }}</p>
            @endif
        </div>
        <div class="card-body">
            <h3>Liste des membres</h3>
            @if($membres->count() > 0)
                <ul class="list-group">
                @foreach($membres as $membre)
                    <li class="list-group-item">
                        <i class="fas fa-user"></i> 
                        {{ $membre->prenom }} {{ $membre->nom }}
                    </li>
                @endforeach
                </ul>
            @else
                <p>Aucun membre dans cette équipe.</p>
            @endif
        </div>
        <div class="card-footer">
            <a href="{{ url()->previous() }}" class="btn btn-primary">Retour</a>
        </div>
    </div>
</div>
@endsection