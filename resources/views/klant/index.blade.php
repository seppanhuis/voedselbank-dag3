@vite(['resources/css/app.css', 'resources/js/app.js'])
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overzicht Klanten - Voedselbank Maaskantje</title>
</head>
<body>
<div class="container py-4">
    <!-- Header met titel links en filter rechts -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 mb-0" style="color: #3a7d3a; font-weight: 600; text-decoration: underline;">Overzicht Klanten</h1>
        
        <form method="GET" action="{{ route('klant.index') }}" class="d-flex gap-2">
            <div style="width: 250px;">
                <select name="postcode" class="form-select" id="postcodeSelect" title="Selecteer Postcode">
                    <option value="">Selecteer Postcode</option>
                    @foreach($postcodes as $pc)
                    <option value="{{ $pc->Postcode }}" {{ $selectedPostcode === $pc->Postcode ? 'selected' : '' }}>
                        {{ $pc->Postcode }}
                    </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Toon Klanten</button>
        </form>
    </div>

    <!-- Klanten Tabel -->
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead style="background-color: #f5f5f5;">
                <tr>
                    <th>Naam Gezin</th>
                    <th>Vertegenwoordiger</th>
                    <th>E-mailadres</th>
                    <th>Mobiel</th>
                    <th>Adres</th>
                    <th>Woonplaats</th>
                    <th>Klant Details</th>
                </tr>
            </thead>
            <tbody>
                @forelse($klanten as $klant)
                <tr>
                    <td>{{ $klant->NaamGezin ?? '~~~~' }}</td>
                    <td>{{ $klant->Vertegenwoordiger ?? '~~~~' }}</td>
                    <td>{{ $klant->Email ?? '~~~~' }}</td>
                    <td>{{ $klant->Mobiel ?? '~~~~' }}</td>
                    <td>{{ $klant->Adres ?? '~~~~' }}</td>
                    <td>{{ $klant->Woonplaats ?? '~~~~' }}</td>
                    <td>
                        <a href="{{ route('klant.edit', $klant->GezinId) }}" class="btn btn-sm btn-primary" title="Details">
                            Details
                        </a>
                    </td>
                </tr>
                @empty
                <tr style="background-color: transparent !important; margin: 10px !important;">
                    <td colspan="7" class="text-center" style="background-color: #ffd997 !important; padding: 20px !important; border-radius: 8px !important; margin: 10px !important;">Er zijn geen klanten bekent die de geselecteerde postcode hebben</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4 d-flex justify-content-end">
        <a href="{{ route('home') }}" class="btn btn-primary">home</a>
    </div>
</div>
</body>
</html>
