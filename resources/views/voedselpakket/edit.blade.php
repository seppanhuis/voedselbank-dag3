@vite(['resources/css/app.css', 'resources/js/app.js'])
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wijzig voedselpakket status</title>
</head>
<body class="bg-light">
<div class="container mt-5 mb-5">
    <h2 class="fw-normal mb-4" style="color: #228B22;">Wijzig voedselpakket status</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- ✅ FIX: juiste Id gebruiken + geen ?? 0 -->
    <form method="POST" action="{{ route('voedselpakket.update', ['pakketId' => $pakket->Id]) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <select name="status" class="form-select" {{ !$gezinIngeschreven ? 'disabled' : '' }}>

                <!-- ✅ FIX: Status met hoofdletter -->
                <option value="Niet Uitgereikt" {{ ($pakket->Status ?? '') == 'Niet Uitgereikt' ? 'selected' : '' }}>
                    Niet Uitgereikt
                </option>

                <option value="Uitgereikt" {{ ($pakket->Status ?? '') == 'Uitgereikt' ? 'selected' : '' }}>
                    Uitgereikt
                </option>

            </select>
        </div>

        @if(!$gezinIngeschreven)
            <div class="alert alert-danger">
                Dit gezin is niet meer ingeschreven bij de voedselbank en daarom kan er geen voedselpakket worden uitgereikt
            </div>
        @endif

        <button type="submit" class="btn btn-secondary" style="min-width:220px;" {{ !$gezinIngeschreven ? 'disabled' : '' }}>
            Wijzig status voedselpakket
        </button>
    </form>

    <div class="d-flex justify-content-end mt-3 gap-2">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">terug</a>
        <a href="/" class="btn btn-primary">home</a>
    </div>
</div>

<!-- ✅ FIX: geen hardcoded gezinId -->
@if(session('success'))
<script>
    setTimeout(function(){
        window.location.href = "{{ route('voedselpakket.details', ['gezinId' => $pakket->GezinId]) }}";
    }, 3000);
</script>
@endif

</body>
</html>
