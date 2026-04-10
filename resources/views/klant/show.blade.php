@vite(['resources/css/app.css', 'resources/js/app.js'])
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klant Details - Voedselbank Maaskantje</title>
</head>
<body>
<div class="container py-4">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <script>
        setTimeout(function() {
            window.location.href = "{{ route('klant.index') }}";
        }, 3000);
    </script>
    @endif

    <div class="mb-4">
        <h1 class="h2 mb-4" style="color: #3a7d3a; font-weight: 600;">Klant Details Arjan Bergkamp</h1>

        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Voornaam</label>
                        <p class="form-control-plaintext">{{ $klant->Voornaam ?? '~~~~' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Tussenvoegsel</label>
                        <p class="form-control-plaintext">{{ $klant->Tussenvoegsel ?? '~~~~' }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Achternaam</label>
                        <p class="form-control-plaintext">{{ $klant->Achternaam ?? '~~~~' }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Geboortedatum</label>
                        <p class="form-control-plaintext">{{ $klant->Geboortedatum ? \Carbon\Carbon::parse($klant->Geboortedatum)->format('d-m-Y') : '~~~~' }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Type Persoon</label>
                        <p class="form-control-plaintext">{{ $klant->TypePersoon ?? '~~~~' }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Vertegenwoordiger</label>
                        <p class="form-control-plaintext">{{ $klant->Vertegenwoordiger ?? 'Ja' }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Straatnaam</label>
                        <p class="form-control-plaintext">{{ $klant->Straat ?? '~~~~' }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Huisnummer</label>
                        <p class="form-control-plaintext">{{ $klant->Huisnummer ?? '~~~~' }}</p>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label fw-bold">Toevoeging</label>
                        <p class="form-control-plaintext">{{ $klant->Toevoeging ?? '~~~~' }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Postcode</label>
                        <p class="form-control-plaintext">{{ $klant->Postcode ?? '~~~~' }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Woonplaats</label>
                        <p class="form-control-plaintext">{{ $klant->Woonplaats ?? '~~~~' }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold">E-mail</label>
                        <p class="form-control-plaintext">{{ $klant->Email ?? '~~~~' }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Mobiel</label>
                        <p class="form-control-plaintext">{{ $klant->Mobiel ?? '~~~~' }}</p>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-between">
                    <a href="{{ route('klant.edit', $klant->GezinId) }}" class="btn btn-primary">Wijzig</a>
                    <div class="d-flex gap-2">
                        <a href="{{ route('klant.index') }}" class="btn btn-primary">terug</a>
                        <a href="{{ route('home') }}" class="btn btn-primary">home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
