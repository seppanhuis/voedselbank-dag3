@vite(['resources/css/app.css', 'resources/js/app.js'])
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wijzig Klant Details - Voedselbank Maaskantje</title>
</head>
<body>
<div class="container py-4">
    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>De contactgegevens van de geselecteerde klant kunnen niet gewijzigd</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="mb-4">
        <h1 class="h2 mb-4" style="color: #3a7d3a; font-weight: 600;">Wijzig Klant Details Arjan Bergkamp</h1>

        <form method="POST" action="{{ route('klant.update', $klant->GezinId) }}" class="card">
            @csrf
            @method('PUT')
            <input type="hidden" name="contact_id" value="{{ $klant->ContactId ?? '' }}">
            <input type="hidden" name="persoon_id" value="{{ $klant->PersoonId ?? '' }}">
            
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="voornaam" class="form-label fw-bold">Voornaam</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control @error('voornaam') is-invalid @enderror" 
                               id="voornaam" name="voornaam" value="{{ old('voornaam', $klant->Voornaam ?? '') }}" required>
                        @error('voornaam')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="tussenvoegsel" class="form-label fw-bold">Tussenvoegsel</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control @error('tussenvoegsel') is-invalid @enderror" 
                               id="tussenvoegsel" name="tussenvoegsel" value="{{ old('tussenvoegsel', $klant->Tussenvoegsel ?? '') }}">
                        @error('tussenvoegsel')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="achternaam" class="form-label fw-bold">Achternaam</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control @error('achternaam') is-invalid @enderror" 
                               id="achternaam" name="achternaam" value="{{ old('achternaam', $klant->Achternaam ?? '') }}" required>
                        @error('achternaam')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="geboortedatum" class="form-label fw-bold">Geboortedatum</label>
                    </div>
                    <div class="col-md-8">
                        <input type="date" class="form-control" 
                               id="geboortedatum" name="geboortedatum" 
                               value="{{ $klant->Geboortedatum ? \Carbon\Carbon::parse($klant->Geboortedatum)->format('Y-m-d') : '' }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="typepersoon" class="form-label fw-bold">Type Persoon</label>
                    </div>
                    <div class="col-md-8">
                        <select class="form-select" id="typepersoon" name="typepersoon">
                            <option value="Manager" {{ $klant->TypePersoon === 'Manager' ? 'selected' : '' }}>Manager</option>
                            <option value="Vrijwilliger" {{ $klant->TypePersoon === 'Vrijwilliger' ? 'selected' : '' }}>Vrijwilliger</option>
                            <option value="Klant" {{ $klant->TypePersoon === 'Klant' ? 'selected' : '' }}>Klant</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="vertegenwoordiger" class="form-label fw-bold">Vertegenwoordiger</label>
                    </div>
                    <div class="col-md-8">
                        <select class="form-select" id="vertegenwoordiger" name="vertegenwoordiger">
                            <option value="Ja" selected>Ja</option>
                            <option value="Nee">Nee</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="straat" class="form-label fw-bold">Straatnaam</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control @error('straat') is-invalid @enderror" 
                               id="straat" name="straat" value="{{ old('straat', $klant->Straat ?? '') }}" required>
                        @error('straat')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="huisnummer" class="form-label fw-bold">Huisnummer</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control @error('huisnummer') is-invalid @enderror" 
                               id="huisnummer" name="huisnummer" value="{{ old('huisnummer', $klant->Huisnummer ?? '') }}" required>
                        @error('huisnummer')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="toevoeging" class="form-label fw-bold">Toevoeging</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control @error('toevoeging') is-invalid @enderror" 
                               id="toevoeging" name="toevoeging" value="{{ old('toevoeging', $klant->Toevoeging ?? '') }}">
                        @error('toevoeging')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="postcode" class="form-label fw-bold">Postcode</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control @error('postcode') is-invalid @enderror" 
                               id="postcode" name="postcode" placeholder="5271TH" 
                               value="{{ old('postcode', $klant->Postcode ?? '') }}" required>
                        @error('postcode')
                        <div class="invalid-feedback d-block">
                            <small style="color: #dc3545;">{{ $message }}</small>
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="woonplaats" class="form-label fw-bold">Woonplaats</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control @error('woonplaats') is-invalid @enderror" 
                               id="woonplaats" name="woonplaats" value="{{ old('woonplaats', $klant->Woonplaats ?? '') }}" required>
                        @error('woonplaats')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="email" class="form-label fw-bold">E-mail</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', $klant->Email ?? '') }}" required>
                        @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="mobiel" class="form-label fw-bold">Mobiel</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" class="form-control @error('mobiel') is-invalid @enderror" 
                               id="mobiel" name="mobiel" value="{{ old('mobiel', $klant->Mobiel ?? '') }}" required>
                        @error('mobiel')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Wijzig Klant Details</button>
                    <div class="d-flex gap-2">
                        <a href="{{ route('klant.index') }}" class="btn btn-primary">terug</a>
                        <a href="{{ route('home') }}" class="btn btn-primary">home</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>
