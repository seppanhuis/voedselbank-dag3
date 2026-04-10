@vite(['resources/css/app.css', 'resources/js/app.js'])
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overzicht gezinnen met voedselpakketten</title>
</head>
<body class="bg-light">
<div class="container mt-5 mb-5">
    <div class="row mb-4 align-items-center">
        <div class="col-8">
            <h2 class="fw-normal" style="color: #228B22;">
                Overzicht gezinnen met voedselpakketten
            </h2>
        </div>
        <div class="col-4 text-end">
            <form method="GET" action="{{ route('voedselpakket.index') }}" class="d-inline-block">
                <div class="input-group">
                    <select name="eetwens" class="form-select">
                        <option value="" {{ empty($eetwens) ? 'selected' : '' }}>Selecteer Eetwens</option>
                        <option value="Omnivoor" {{ $eetwens == 'Omnivoor' ? 'selected' : '' }}>Omnivoor</option>
                        <option value="Vegetarisch" {{ $eetwens == 'Vegetarisch' ? 'selected' : '' }}>Vegetarisch</option>
                        <option value="Veganistisch" {{ $eetwens == 'Veganistisch' ? 'selected' : '' }}>Veganistisch</option>
                        <option value="GeenVarken" {{ $eetwens == 'GeenVarken' ? 'selected' : '' }}>GeenVarken</option>
                    </select>
                    <button type="submit" class="btn btn-secondary">Toon Gezinnen</button>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered align-middle mb-0">
            <thead>
                <tr>
                    <th>Gezinsnaam</th>
                    <th>Omschrijving</th>
                    <th>Volwassenen</th>
                    <th>Kinderen</th>
                    <th>Babys</th>
                    <th>Vertegenwoordiger</th>
                    <th>Voedselpakket Details</th>
                </tr>
            </thead>
            <tbody>
                @if(count($gezinnen) === 0)
                    <tr>
                        <td colspan="7">
                            <div class="alert alert-warning mb-0 text-center" role="alert">
                                Er zijn geen gezinnen bekend die de geselecteerde eetwens hebben
                            </div>
                        </td>
                    </tr>
                @else
                    @foreach($gezinnen as $gezin)
                        <tr>
                            <td>{{ $gezin->naam ?? 'Onbekend' }}</td>
                            <td>{{ $gezin->omschrijving ?? '' }}</td>
                            <td>{{ $gezin->volwassenen ?? '' }}</td>
                            <td>{{ $gezin->kinderen ?? '' }}</td>
                            <td>{{ $gezin->babys ?? '' }}</td>
                            <td>{{ $gezin->vertegenwoordiger ?? '' }}</td>
                            <td class="text-center">
                                <a href="{{ route('voedselpakket.details', ['gezinId' => $gezin->id ?? 0]) }}" title="Details">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="#1976d2" stroke-width="2" viewBox="0 0 24 24">
                                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                                        <path d="M3 9h18"/>
                                        <path d="M9 21V9"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-end mt-3">
        <a href="/" class="btn btn-primary" style="min-width: 80px;">home</a>
    </div>
</div>
</body>
</html>
