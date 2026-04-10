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
    <div class="wireframe-card p-4 p-md-4 p-lg-5" style="max-width: 960px;">
        <h3 class="h1 mb-4">
            <a class="title-link" href="#">Wijzig Product</a>
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

        <form method="POST" action="{{ route('leverancier.product.update', ['productPerLeverancierId' => $product->ProductPerLeverancierId]) }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="leverancier_id" value="{{ $product->LeverancierId }}">

            <div class="row align-items-center gy-2 mb-3">
                <div class="col-12 col-md-5">
                    <label for="houdbaarheidsdatum" class="form-label fw-semibold fs-2 mb-0">Houdbaarheidsdatum:</label>
                </div>
                <div class="col-12 col-md-7">
                    <input
                        type="date"
                        id="houdbaarheidsdatum"
                        name="houdbaarheidsdatum"
                        class="form-control form-control-lg"
                        value="{{ old('houdbaarheidsdatum', \Carbon\Carbon::parse($product->Houdbaarheidsdatum)->format('Y-m-d')) }}"
                        required
                    >
                </div>
            </div>

            @if(session('validation_error'))
                <div class="text-danger fs-5 mb-3">
                    {{ session('validation_error') }}
                </div>
            @endif

            @error('houdbaarheidsdatum')
                <div class="text-danger fs-2 mb-3">{{ $message }}</div>
            @enderror

            <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-2">
                <button type="submit" class="btn btn-secondary btn-lg">Wijzig Houdbaarheidsdatum</button>
                <div class="d-flex gap-2">
                    <a href="{{ route('leverancier.producten', ['leverancierId' => $product->LeverancierId]) }}" class="btn btn-primary btn-lg">Terug</a>
                    <a href="{{ url('/') }}" class="btn btn-primary btn-lg">Home</a>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>
