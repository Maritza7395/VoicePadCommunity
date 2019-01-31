<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
</head>
<body>
    <div>
        <h2>Hola {{ $name }}</h2>
        {!! html_entity_decode($text) !!}
    </div>
   <p>Visitanos en : <a href="{{ url('/')}}"> VoicePad Community </a> </p>
    
</body>
</html>
