<!DOCTYPE html>
<html>
<head>
    <title>Nouveau emploi du temps</title>
</head>
<body>
    <h1>Nouveau emploi du temps</h1>
    <p>Bonjour {{ $fullname }},</p>
    <p>Vous avez été programmé sur la plateforme d'emploi du temps.</p>
    <p>La liste des matieres programmées :
        <ul>
            @foreach ($subjects as $subject)
                <li>{{ $subject }}</li>
            @endforeach
        </ul>
    </p>
    <p>
        La liste des classes concernées :
        <ul>
            @foreach ($levels as $level)
                <li>{{ $level }}</li>
            @endforeach
        </ul>
    </p>
    <p>Veuillez vous conntecter pour voir l'emploi du temps.</p>
    <p>Merci,</p>
    <p>{{ config('app.name') }}</p>
</body>
</html>