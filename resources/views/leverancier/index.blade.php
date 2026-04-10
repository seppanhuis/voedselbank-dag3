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
			<a class="title-link" href="{{ route('leverancier.index') }}">Overzicht Leveranciers</a>
		</h3>

		@if(session('error') || !empty($error))
			<div class="alert alert-danger">
				{{ session('error') ?? $error }}
			</div>
		@endif

		<form method="GET" action="{{ route('leverancier.index') }}" class="row g-2 justify-content-end mb-2">
			<div class="col-12 col-md-4 col-lg-3">
				<select name="leverancier_type" class="form-select">
					<option value="">Selecteer Leveranciertype</option>
					@foreach($leverancierTypes as $leverancierType)
						<option value="{{ $leverancierType->LeverancierType }}" @selected($selectedType === $leverancierType->LeverancierType)>
							{{ $leverancierType->LeverancierType }}
						</option>
					@endforeach
				</select>
			</div>
			<div class="col-12 col-md-auto">
				<button type="submit" class="btn btn-secondary w-100">Toon Leveranciers</button>
			</div>
		</form>

		<div class="table-responsive">
			<table class="table table-bordered table-sm align-middle mb-3">
				<thead class="table-light">
				<tr>
					<th>Naam</th>
					<th>Contactpersoon</th>
					<th>Email</th>
					<th>Mobiel</th>
					<th>Leveranciernummer</th>
					<th>LeverancierType</th>
					<th class="text-center">Product Details</th>
				</tr>
				</thead>
				<tbody>
				@if(!empty($showNoDataWarning))
					<tr>
						<td colspan="7">
							<div class="alert alert-warning text-center mb-0">
								Er zijn geen leveranciers bekent van het geselecteerde leverancierstype
							</div>
						</td>
					</tr>
				@else
					@forelse($leveranciers as $leverancier)
						<tr>
							<td>{{ $leverancier->Naam }}</td>
							<td>{{ $leverancier->ContactPersoon }}</td>
							<td>{{ $leverancier->Email }}</td>
							<td>{{ $leverancier->Mobiel }}</td>
							<td>{{ $leverancier->LeverancierNummer }}</td>
							<td>{{ $leverancier->LeverancierType }}</td>
							<td class="text-center">
								<a class="icon-link" href="{{ route('leverancier.producten', ['leverancierId' => $leverancier->LeverancierId]) }}" title="Bekijk product details">&#128196;</a>
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="7" class="text-center text-muted">Geen leveranciers beschikbaar</td>
						</tr>
					@endforelse
				@endif
				</tbody>
			</table>
		</div>

		<div class="d-flex justify-content-end">
			<a href="{{ url('/') }}" class="btn btn-primary btn-sm">Home</a>
		</div>
	</div>
</div>
</body>
</html>
