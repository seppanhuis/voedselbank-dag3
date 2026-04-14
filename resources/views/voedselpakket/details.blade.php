@vite(['resources/css/app.css', 'resources/js/app.js'])
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overzicht Voedselpakketten</title>
</head>
<body class="bg-light">
<div class="container mt-5 mb-5">
    <h2 class="fw-normal mb-4" style="color: #228B22;">Overzicht Voedselpakketten</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <table class="table w-auto mb-4">
        <tr><th>Naam:</th><td>{{ $gezin->Naam ?? '' }}</td></tr>
        <tr><th>Omschrijving:</th><td>{{ $gezin->Omschrijving ?? '' }}</td></tr>
        <tr><th>Totaal aantal Personen:</th><td>{{ $gezin->TotaalAantalPersonen ?? '' }}</td></tr>
    </table>
    <div class="table-responsive">
        <table class="table table-bordered align-middle mb-0">
            <thead>
                <tr>
                    <th>Pakketnummer</th>
                    <th>Datum samenstelling</th>
                    <th>Datum uitgifte</th>
                    <th>Status</th>
                    <th>Aantal producten</th>
                    <th>Wijzig Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($voedselpakketten as $pakket)
                <tr>
                    <td>{{ $pakket->PakketNummer ?? '~~~~~' }}</td>
                    <td>{{ $pakket->DatumSamenstelling ?? '~~~~~' }}</td>
                    <td>{{ $pakket->DatumUitgifte ?? '-' }}</td>
                    <td>{{ $pakket->Status ?? '~~~~~' }}</td>
                    <td>{{ $pakket->aantal_producten ?? '~~~~~' }}</td>
                    <td class="text-center">
                        <a href="{{ route('voedselpakket.edit', ['pakketId' => $pakket->Id ?? $pakket->id]) }}" title="Wijzig Status">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#1976d2" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-end mt-3 gap-2">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">terug</a>
        <a href="/" class="btn btn-primary">home</a>
    </div>
</div>
</body>
</html>
