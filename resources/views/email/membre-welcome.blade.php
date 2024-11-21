<!DOCTYPE html>
<html>
<head>
    <title>Bienvenue dans l'équipe</title>
</head>
<body>
    <h1>Bienvenue {{ $membre->prenom }} !</h1>
    <p>Vous avez été ajouté(e) à l'équipe {{ $equipe->nomequipe }}.</p>
    <p>Vous pouvez maintenant participer au hackathon avec votre équipe.</p>
</body>
</html>