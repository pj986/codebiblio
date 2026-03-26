<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation d'Emprunt</title>
    <style>
        /* Définition des styles de l'email */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #2c3e50;
            font-size: 24px;
            margin-bottom: 15px;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
            color: #555;
        }

        strong {
            color: #2c3e50;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #aaa;
        }

        .footer a {
            color: #3498db;
            text-decoration: none;
        }

        .button {
            display: inline-block;
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Confirmation d'emprunt</h2>
        <p>Bonjour {{ auth()->user()->name }},</p>
        <p>Vous avez emprunté le livre : <strong>{{ $titre }}</strong></p>
        <p>Date de retour prévue : <strong>{{ $date_retour }}</strong></p>

        <p>Merci d'utiliser BiblioTEK 📚</p>

        <p class="footer">Si vous avez des questions, vous pouvez <a href="#">nous contacter</a>.</p>
        
        <a href="#" class="button">Retourner au site</a>
    </div>

</body>
</html>