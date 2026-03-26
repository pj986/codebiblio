<h1>📜 Logs Admin</h1>

@foreach($logs as $log)
    <p>
        {{ $log->created_at }} → 
        {{ $log->action }} ({{ $log->target }})
    </p>
@endforeach

<a href="/bo/profils">Retour</a>