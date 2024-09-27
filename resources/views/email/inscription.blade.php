<!DOCTYPE html>
<html>
<head>
    <title>Inscription au Hackathon {{ $hackathon->thematique }}</title>
</head>
<body>
    <h1>Félicitations {{ $equipe->nomequipe }} !</h1>
    <p>Votre équipe est désormais inscrite au hackathon <strong>{{ $hackathon->thematique }}</strong>.</p>
    <p>Date de début : {{ $hackathon->dateheuredebuth }}</p>
    <p>Lieu : {{ $hackathon->lieu }}, {{ $hackathon->ville }}</p>
    <p>Nous vous souhaitons bonne chance !</p>
    <p>Pour toute question, contactez {{ $hackathon->organisateur->email }}.</p>
</body>
</html>
