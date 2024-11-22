<!DOCTYPE html>
<html>
<head>
    <title>Bienvenue dans l'équipe</title>
</head>
<body>
    <h1>Bienvenue {{ $membre->prenom }} {{ $membre->nom }}</h1>
    <p>Vous avez été ajouté à l'équipe {{ $equipe->nomequipe }}.</p>
</body>
</html>
