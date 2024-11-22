
@extends('layouts.app')

@section('title', ' - Mon équipe')

@section('content')
<div class="container">
    <h1 class="mt-4">Mon équipe</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="list-unstyled m-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <h3>{{ $connected->nomequipe }}</h3>

            @if ($hackathon != null)
                <h5 class="text-muted">Hackathon : {{ $hackathon->thematique }}</h5>
                @if ($hackathon->affiche)
                    <img src="{{ $hackathon->affiche }}" alt="Affiche de l'évènement" class="img-fluid mt-3" style="max-width: 300px"/>
                @endif
                <form action="{{ route('quit-hackathon') }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir quitter ce hackathon ?');">
                    @csrf
                    <input type="hidden" name="idhackathon" value="{{ $hackathon->idhackathon }}">
                    <button type="submit" class="btn btn-danger mt-3">Quitter l'événement</button>
                </form>
            @else
                <p class="text-muted">Aucun hackathon en cours</p>
            @endif

            <!-- Bouton pour éditer le profil -->
            <a href="{{ route('edit-profile') }}" class="btn btn-secondary mt-3">Éditer le profil</a>

            <div class="card cardRadius mt-3">
                <div class="card-body">
                    <h3>Télécharger les données</h3>
                    <p>Pour respecter vos droits RGPD, vous pouvez télécharger toutes les données liées à votre équipe.</p>
                    <a href="{{ route('equipe.download-data') }}" class="btn btn-primary">
                        <i class="fas fa-download"></i> Télécharger les données
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Membres -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Membres de l'équipe</h5>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMemberModal">
                <i class="fas fa-plus me-2"></i>Ajouter un membre
            </button>
        </div>
        <div class="card-body">
            <div class="members-list">
                @forelse ($membres as $membre)
                    <div class="member-card p-3 mb-2 border rounded" data-id="{{ $membre->idmembre }}">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">{{ $membre->prenom }} {{ $membre->nom }}</h6>
                                <p class="mb-1 text-muted">
                                    <i class="fas fa-envelope me-2"></i>{{ $membre->email }}
                                    @if ($membre->telephone)
                                        <br><i class="fas fa-phone me-2"></i>{{ $membre->telephone }}
                                    @endif
                                </p>
                            </div>
                            <button class="btn btn-danger btn-sm" onclick="deleteMembre({{ $membre->idmembre }}, '{{ $membre->nom }} {{ $membre->prenom }}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-muted">Aucun membre dans l'équipe</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Modal Ajout Membre -->
<div class="modal fade" id="addMemberModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="addMemberForm" class="needs-validation" novalidate>
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un membre</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nom</label>
                        <input type="text" name="nom" class="form-control" required>
                        <div class="invalid-feedback">
                            Veuillez entrer un nom.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Prénom</label>
                        <input type="text" name="prenom" class="form-control" required>
                        <div class="invalid-feedback">
                            Veuillez entrer un prénom.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                        <div class="invalid-feedback">
                            Veuillez entrer un email valide.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Téléphone</label>
                        <input type="tel" name="telephone" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date de naissance</label>
                        <input type="date" name="datenaissance" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lien Portfolio</label>
                        <input type="url" name="lienportfolio" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Validation côté client
    const forms = document.querySelectorAll('.needs-validation');
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
});

function deleteMembre(id, name) {
    if (confirm(`Êtes-vous sûr de vouloir supprimer ${name} ?`)) {
        fetch(`/api/membre/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.querySelector(`[data-id="${id}"]`).remove();
            } else {
                alert(data.message || 'Erreur lors de la suppression');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue');
        });
    }
}

document.getElementById('addMemberForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);

    fetch('/api/membre', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const memberList = document.querySelector('.members-list');
            const newMember = document.createElement('div');
            newMember.classList.add('member-card', 'p-3', 'mb-2', 'border', 'rounded');
            newMember.setAttribute('data-id', data.membre.idmembre);
            newMember.innerHTML = `
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">${data.membre.prenom} ${data.membre.nom}</h6>
                        <p class="mb-1 text-muted">
                            <i class="fas fa-envelope me-2"></i>${data.membre.email}
                            ${data.membre.telephone ? `<br><i class="fas fa-phone me-2"></i>${data.membre.telephone}` : ''}
                        </p>
                    </div>
                    <button class="btn btn-danger btn-sm" onclick="deleteMembre(${data.membre.idmembre}, '${data.membre.nom} ${data.membre.prenom}')">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
            memberList.appendChild(newMember);
            form.reset();
            form.classList.remove('was-validated');
            $('#addMemberModal').modal('hide');
        } else {
            alert(data.message || 'Erreur lors de l\'ajout du membre');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Une erreur est survenue');
    });
});
</script>
@endsection