
@extends('layouts.app')

@section('title', ' - À propos')

@section('content')
<div class="container my-5">
    <div class="card">
        <div class="card-body">
            <h1 class="mb-4">À propos de Hackat'innov</h1>
            
            <h2 class="h4 mt-4">Notre Mission</h2>
            <p>Hackat'innov facilite l'organisation de hackathons en France, favorisant l'innovation numérique au service de la société.</p>

            <h2 class="h4 mt-4">Protection des Données (RGPD)</h2>
            <div class="mt-3">
                <h3 class="h5">1. Collecte des données</h3>
                <p>Nous collectons uniquement les données nécessaires :</p>
                <ul>
                    <li>Nom et prénom des participants</li>
                    <li>Adresse email</li>
                    <li>Informations de l'équipe</li>
                </ul>

                <h3 class="h5">2. Utilisation des données</h3>
                <p>Vos données sont utilisées pour :</p>
                <ul>
                    <li>Gérer votre participation aux hackathons</li>
                    <li>Communiquer les informations essentielles</li>
                    <li>Assurer le bon déroulement des événements</li>
                </ul>

                <h3 class="h5">3. Vos droits</h3>
                <p>Conformément au RGPD, vous disposez des droits suivants :</p>
                <ul>
                    <li>Accès à vos données</li>
                    <li>Rectification des informations</li>
                    <li>Suppression de votre compte</li>
                    <li>Opposition au traitement</li>
                </ul>
            </div>
            <a href="{{ route('stats.public') }}" class="btn btn-info mt-3">Voir les statistiques publiques</a>
        </div>
    </div>
</div>
@endsection