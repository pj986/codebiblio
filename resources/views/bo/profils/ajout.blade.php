<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un utilisateur</title>

    <!-- Ajouter Font Awesome pour des icônes élégantes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* Style global */
        body {
            font-family: 'Arial', sans-serif;
            background: #f0f2f5;
            padding: 40px;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h1 {
            font-size: 30px;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Container du formulaire */
        .form-container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            margin-top: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .form-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        /* Champs du formulaire */
        label {
            font-size: 14px;
            color: #555;
            margin-bottom: 8px;
            display: block;
        }

        input, select, button {
            width: 100%;
            padding: 12px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-bottom: 20px;
            font-size: 14px;
            color: #333;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #3498db;
        }

        /* Boutons */
        button {
            background-color: #3498db;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #2779bd;
        }

        /* Icones pour les champs */
        .input-container {
            position: relative;
        }

        .input-container i {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #aaa;
        }

        input, select {
            padding-left: 40px;
        }

        /* Effet de focus sur le label */
        input:focus ~ label, select:focus ~ label {
            color: #3498db;
            font-weight: bold;
        }

    </style>
</head>
<body>

<h1>Ajouter un utilisateur</h1>

<div class="form-container">
    <form method="POST" action="{{ route('admin.user.store') }}">
        @csrf

        <!-- Nom -->
        <div class="input-container">
            <i class="fas fa-user"></i>
            <label for="name">Nom</label>
            <input type="text" name="name" id="name" required placeholder="Entrez le nom">
        </div>

        <!-- Email -->
        <div class="input-container">
            <i class="fas fa-envelope"></i>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required placeholder="Entrez l'email">
        </div>

        <!-- Mot de passe -->
        <div class="input-container">
            <i class="fas fa-lock"></i>
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" required placeholder="Entrez le mot de passe">
        </div>

        <!-- Confirmation du mot de passe -->
        <div class="input-container">
            <i class="fas fa-lock"></i>
            <label for="password_confirmation">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="Confirmez le mot de passe">
        </div>

        <!-- Rôle -->
        <div class="input-container">
            <i class="fas fa-users"></i>
            <label for="role">Rôle</label>
            <select name="role" id="role" required>
                <option value="user">Utilisateur</option>
                <option value="admin">Administrateur</option>
            </select>
        </div>

        <button type="submit">Ajouter l'utilisateur</button>
    </form>
</div>

</body>
</html>