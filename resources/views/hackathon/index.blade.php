@extends('layouts.app')

@section('title', ' - Hackathons')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-center">Hackathons</h1>

    <h2 class="mt-4">Hackathons à venir</h2>
    @if ($hackathonsFuturs->isEmpty())
        <p>Aucun hackathon à venir.</p>
    @else
        <div class="row">
            @foreach ($hackathonsFuturs as $hackathon)
                <div class="col-md-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $hackathon->thematique }}</h5>
                            <p><strong>Date :</strong> {{ \Carbon\Carbon::parse($hackathon->dateheuredebuth)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($hackathon->dateheurefinh)->format('d/m/Y') }}</p>
                            <p><strong>Lieu :</strong> {{ $hackathon->lieu }}, {{ $hackathon->ville }}</p>
                            <a href="{{ route('hackathon.show', $hackathon->idhackathon) }}" class="btn btn-primary">Voir les détails</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <h2 class="mt-4">Hackathons passés</h2>
    @if ($hackathonsPasses->isEmpty())
        <p>Aucun hackathon passé.</p>
    @else
        <div class="row">
            @foreach ($hackathonsPasses as $hackathon)
                <div class="col-md-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $hackathon->thematique }}</h5>
                            <p><strong>Date :</strong> {{ \Carbon\Carbon::parse($hackathon->dateheuredebuth)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($hackathon->dateheurefinh)->format('d/m/Y') }}</p>
                            <p><strong>Lieu :</strong> {{ $hackathon->lieu }}, {{ $hackathon->ville }}</p>
                            <a href="{{ route('hackathon.show', $hackathon->idhackathon) }}" class="btn btn-primary">Voir les détails</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection