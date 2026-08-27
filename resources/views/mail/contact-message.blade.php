<h1>{{ $confirmation ? 'Messaggio ricevuto' : 'Nuovo messaggio' }}</h1>

@if ($confirmation)
    <p>Ciao {{ $contact['name'] }}, abbiamo ricevuto il tuo messaggio e ti risponderemo presto.</p>
@else
    <p><strong>Da:</strong> {{ $contact['name'] }} ({{ $contact['email'] }})</p>
@endif

<p>{{ $contact['message'] }}</p>
