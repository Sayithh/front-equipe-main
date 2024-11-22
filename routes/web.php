<?php

use App\Http\Controllers\ApiDocController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\EquipeController;
use App\Http\Controllers\HackathonController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\IsEquipeConnected;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\MembreController;



// Inclusion des routes API supplémentaires
include('inc/api.php');


Route::post('/logout', [EquipeController::class, 'logout'])->name('logout');

// Routes principales accessibles sans authentification
Route::get('/', [MainController::class, 'home'])->name('home');
Route::get('/about', [MainController::class, 'about'])->name('about');

// Routes pour la gestion d'authentification et d'équipe
Route::get('/login', [EquipeController::class, 'login'])->name('login');
Route::post('/login', [EquipeController::class, 'connect'])->name('connect');
Route::get('/join', [HackathonController::class, 'join'])->name('join');
Route::any('/create-team', [EquipeController::class, 'create'])->name('create-team');

// Routes pour la documentation API
Route::prefix('doc-api')->group(function () {
    Route::get('/', [ApiDocController::class, 'liste'])->name('doc-api');
    Route::get('/hackathons', [ApiDocController::class, 'listeHackathons'])->name('doc-api-hackathons');
    Route::get('/membres', [ApiDocController::class, 'listeMembres'])->name('doc-api-membres');
    Route::get('/equipes', [ApiDocController::class, 'listeEquipes'])->name('doc-api-equipes');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/equipe/membres', [EquipeController::class, 'showMembers'])->name('equipe.membres');
    Route::post('/equipe/membres', [EquipeController::class, 'addMembre'])->name('equipe.addMembre');
    Route::delete('/equipe/membres/{id}', [EquipeController::class, 'deleteMembre'])->name('equipe.deleteMembre');
});


// Routes nécessitant une session active (middleware IsEquipeConnected)

Route::middleware(IsEquipeConnected::class)->group(function () {
    Route::get('/me', [EquipeController::class, 'me'])->name('me');
    Route::get('/edit-profile', [EquipeController::class, 'editProfileForm'])->name('edit-profile');
    Route::post('/edit-profile', [EquipeController::class, 'updateProfile'])->name('update-profile');
});

 // Gestion des membres d'équipe
Route::get('/equipe/{idequipe}/membres', [EquipeController::class, 'showMembers'])
        ->name('equipe.membres');

// Routes API spécifiques pour récupérer les membres d'une équipe
Route::get('/membre/{idequipe}', [ApiController::class, 'getByEquipeId'])->name('api.membre.byEquipe');

Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

Route::middleware(['admin.auth'])->group(function () {
    Route::get('/doc-api', [ApiDocController::class, 'liste'])->name('doc-api');
    Route::get('/doc-api/hackathons', [ApiDocController::class, 'listeHackathons'])->name('doc-api-hackathons');
    Route::get('/doc-api/membres', [ApiDocController::class, 'listeMembres'])->name('doc-api-membres');
    Route::get('/doc-api/equipes', [ApiDocController::class, 'listeEquipes'])->name('doc-api-equipes');
});

Route::post('/quit-hackathon', [EquipeController::class, 'quitHackathon'])->name('quit-hackathon');

Route::get('/hackathons', [HackathonController::class, 'index'])->name('hackathon.index');
Route::get('/hackathon/{id}', [HackathonController::class, 'show'])->name('hackathon.show');
Route::post('/hackathon/{id}/comment', [HackathonController::class, 'addComment'])->name('hackathon.addComment');
Route::get('/equipe/download-data', [EquipeController::class, 'downloadTeamData'])->name('equipe.download-data');


Route::get('/stats/hackathon/{id}', [StatsController::class, 'hackathonStats'])->name('stats.hackathon');
Route::get('/stats/public', [StatsController::class, 'publicStats'])->name('stats.public');
Route::get('/api/membre/{idEquipe}', [EquipeController::class, 'viewMembers']);
Route::post('/api/add-membre', [EquipeController::class, 'addMembre']);
Route::post('/api/delete-membre', [EquipeController::class, 'deleteMembre']);
