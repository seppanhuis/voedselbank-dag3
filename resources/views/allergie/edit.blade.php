@vite(['resources/css/app.css', 'resources/js/app.js'])
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    @if(session('success') && session('redirect_to_gezin'))
        <meta http-equiv="refresh" content="3;url={{ route('allergie.gezin.show', ['gezinId' => session('redirect_to_gezin')]) }}">
    @endif
</head>
<body>
<div class="container py-4">
    <div class="wireframe-card p-4 p-md-5" style="max-width: 760px;">
        <h3 class="h1 mb-4">
            <a class="title-link" href="#">Wijzig allergie</a>
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

        @if($showMedicalWarning)
            <div class="alert alert-warning" role="alert">
                Voor het wijzigen van deze allergie wordt geadviseerd eerst een arts te raadplegen vanwege een hoog risico op een anafylactisch shock
            </div>
        @endif

        <form method="POST" action="{{ route('allergie.persoon.update', ['persoonId' => $persoonAllergie->PersoonId]) }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="allergie_per_persoon_id" value="{{ $persoonAllergie->AllergiePerPersoonId }}">
            <input type="hidden" name="gezin_id" value="{{ $persoonAllergie->GezinId }}">

            <div class="mb-3">
                <select name="allergie_id" class="form-select form-select-lg" required>
                    @foreach($allergieen as $allergie)
                        <option value="{{ $allergie->Id }}" @selected((int)$allergie->Id === (int)$persoonAllergie->AllergieId)>
                            {{ $allergie->Naam }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <button type="submit" class="btn btn-secondary btn-lg">Wijzig Allergie</button>
                <div class="d-flex gap-2">
                    <a href="{{ route('allergie.gezin.show', ['gezinId' => $persoonAllergie->GezinId]) }}" class="btn btn-primary btn-lg">Terug</a>
                    <a href="{{ url('/') }}" class="btn btn-primary btn-lg">Home</a>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>
