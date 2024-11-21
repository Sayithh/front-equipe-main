
<!DOCTYPE html>
<html>
<head>
    <title>Confirmation d'ajout à l'équipe - Hackat'innov</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #f8f9fa; padding: 20px; text-align: center; }
        .content { padding: 20px; }
        .footer { text-align: center; margin-top: 20px; font-size: 0.9em; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Bienvenue dans l'équipe {{ $equipe->nomequipe }}</h1>
        </div>
        
        <div class="content">
            <h2>Bonjour {{ $membre->prenom }} !</h2>
            
            <p>Vous avez été ajouté(e) à l'équipe {{ $equipe->nomequipe }}.</p>
            
            @if($hackathon)
            <h3>Détails du hackathon :</h3>
            <ul>
                <li>Thème : {{ $hackathon->thematique }}</li>
                <li>Date : {{ date('d/m/Y H:i', strtotime($hackathon->dateheuredebuth)) }}</li>
                <li>Lieu : {{ $hackathon->lieu }}, {{ $hackathon->ville }}</li>
            </ul>
            @endif

            <p>À bientôt !</p>
        </div>

        <div class="footer">
            <p>Hackat'innov - La plateforme des hackathons innovants</p>
        </div>
    </div>
</body>
</html>