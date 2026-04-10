@vite(['resources/css/app.css', 'resources/js/app.js'])
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
</head>
<body>
<div class="container py-4">
    <div class="wireframe-card p-4 p-md-5">
        <h3 class="h2 mb-4">
            <a class="title-link" href="#">Allergie&euml;n in het gezin</a>
        </h3>

        @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <table class="table table-bordered table-sm w-auto mb-4">
            <tbody>
            <tr>
                <th>Gezinsnaam:</th>
                <td>{{ $gezin->Naam }}</td>
            </tr>
            <tr>
                <th>Omschrijving:</th>
                <td>{{ $gezin->Omschrijving }}</td>
            </tr>
            <tr>
                <th>Totaal aantal Personen:</th>
                <td>{{ $gezin->TotaalAantalPersonen }}</td>
            </tr>
            </tbody>
        </table>

        <div class="table-responsive mb-3">
            <table class="table table-bordered table-sm align-middle">
                <thead class="table-light">
                <tr>
                    <th>Naam</th>
                    <th>Type Persoon</th>
                    <th>Gezinsrol</th>
                    <th>Allergie</th>
                    <th class="text-center">Wijzig Allergie</th>
                </tr>
                </thead>
                <tbody>
                @forelse($details as $row)
                    <tr>
                        <td>{{ trim($row->Naam) }}</td>
                        <td>{{ $row->TypePersoon }}</td>
                        <td>{{ $row->Gezinsrol }}</td>
                        <td>{{ $row->AllergieNaam }}</td>
                        <td class="text-center">
                            <a class="icon-link" href="{{ route('allergie.persoon.edit', ['persoonId' => $row->PersoonId]) }}" title="Wijzig allergie">&#9998;</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Geen allergie details gevonden</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('allergie.index') }}" class="btn btn-primary btn-sm">terug</a>
            <a href="{{ url('/') }}" class="btn btn-primary btn-sm">home</a>
        </div>
    </div>
</div>
</body>
</html>
