<!DOCTYPE html>
<html>
<head>
    <title>Compte est crée avec succes</title>
</head>
<body>
    <h1>Votre compte est crée avec succes</h1>
    <p>Bonjour {{ $fullname }},</p>
    <p>Votre compte a été crée sur la plateforme d'emploi du temps, veuillez utiliser votre adresse email et ce code pour vous connecter :</p>
    <h2 style="color: #FFA500">{{ $code }}</h2>
    <p>Type de votre compte : <span style="text-decoration-line: underline">{{ $type }}</span>.</p>
    <p>Pensez à changer le code une fois connecté à votre compte.</p>
    <p>Si vous n'avez pas demandé cette action, veuillez supprimer ce message.</p>
    <p>Merci,</p>
    <p>{{ config('app.name') }}</p>
</body>
</html>