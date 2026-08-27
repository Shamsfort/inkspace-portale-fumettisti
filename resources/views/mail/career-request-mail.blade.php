<!doctype html>
<html lang="it">
<body>
    <h1>Nuova richiesta ricevuta</h1>
    <p><strong>Ruolo:</strong> {{ $info['role'] }}</p>
    <p><strong>Da:</strong> {{ $info['email'] }}</p>
    <p><strong>Messaggio:</strong></p>
    <p>{{ $info['message'] }}</p>
</body>
</html>
