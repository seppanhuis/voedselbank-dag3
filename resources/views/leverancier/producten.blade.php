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
    <div class="wireframe-card p-4 p-md-4 p-lg-5">
        <h3 class="h2 mb-4">
            <a class="title-link" href="#">Overzicht producten</a>
        </h3>

        @if(session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <div class="table-responsive mb-3">
            <table class="table table-bordered table-sm w-auto mb-3">
                <tbody>
                <tr>
                    <th>Leverancier:</th>
                    <td>{{ $leverancier->Naam }}</td>
                </tr>
                <tr>
                    <th>Leveranciernummer:</th>
                    <td>{{ $leverancier->LeverancierNummer }}</td>
                </tr>
                <tr>
                    <th>LeverancierType:</th>
                    <td>{{ $leverancier->LeverancierType }}</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="table-responsive mb-3">
            <table class="table table-bordered table-sm align-middle">
                @php
                    $sortBy = $sortBy ?? 'naam';
                    $sortDirection = $sortDirection ?? 'asc';
                    $nextDirection = static function (string $column) use ($sortBy, $sortDirection): string {
                        return ($sortBy === $column && $sortDirection === 'asc') ? 'desc' : 'asc';
                    };
                @endphp
                <thead class="table-light">
                <tr>
                    <th>
                        <a href="{{ route('leverancier.producten', ['leverancierId' => $leverancier->Id, 'sort' => 'naam', 'direction' => $nextDirection('naam')]) }}">Naam</a>
                    </th>
                    <th>
                        <a href="{{ route('leverancier.producten', ['leverancierId' => $leverancier->Id, 'sort' => 'soort_allergie', 'direction' => $nextDirection('soort_allergie')]) }}">Soort Allergie</a>
                    </th>
                    <th>
                        <a href="{{ route('leverancier.producten', ['leverancierId' => $leverancier->Id, 'sort' => 'barcode', 'direction' => $nextDirection('barcode')]) }}">Barcode</a>
                    </th>
                    <th>
                        <a href="{{ route('leverancier.producten', ['leverancierId' => $leverancier->Id, 'sort' => 'houdbaarheidsdatum', 'direction' => $nextDirection('houdbaarheidsdatum')]) }}">Houdbaarheidsdatum</a>
                    </th>
                    <th class="text-center">Wijzig Product</th>
                </tr>
                </thead>
                <tbody>
                @forelse($producten as $product)
                    <tr>
                        <td>{{ $product->Naam }}</td>
                        <td>{{ $product->SoortAllergie ?? '-' }}</td>
                        <td>{{ $product->Barcode }}</td>
                        <td>{{ \Carbon\Carbon::parse($product->Houdbaarheidsdatum)->format('d-m-Y') }}</td>
                        <td class="text-center">
                            <a class="icon-link" href="{{ route('leverancier.product.edit', ['productPerLeverancierId' => $product->ProductPerLeverancierId]) }}" title="Wijzig product">&#9998;</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Geen producten gevonden voor deze leverancier</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('leverancier.index') }}" class="btn btn-primary btn-sm">Terug</a>
            <a href="{{ url('/') }}" class="btn btn-primary btn-sm">Home</a>
        </div>
    </div>
</div>
</body>
</html>
