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
		<h3 class="h3 mb-4">
			<a class="title-link" href="{{ route('allergie.index') }}">Overzicht gezinnen met allergie&euml;n</a>
		</h3>

		@if(session('error') || !empty($error))
			<div class="alert alert-danger">
				{{ session('error') ?? $error }}
			</div>
		@endif

		<form method="GET" action="{{ route('allergie.index') }}" class="row g-2 justify-content-end mb-3">
			<div class="col-12 col-md-4">
				<select name="allergie_id" class="form-select">
					<option value="">Selecteer Allergie</option>
					@foreach($allergieen as $allergie)
						<option value="{{ $allergie->Id }}" @selected((int) $selectedAllergieId === (int) $allergie->Id)>
							{{ $allergie->Naam }}
						</option>
					@endforeach
				</select>
			</div>
			<div class="col-12 col-md-auto">
				<button type="submit" class="btn btn-secondary w-100">Toon Gezinnen</button>
			</div>
		</form>

		@if(!empty($showNoDataWarning))
			<div class="alert alert-warning text-center">
				Er zijn geen gezinnen bekent die de geselecteerde allergie hebben
			</div>
		@endif

		<div class="table-responsive">
			<table class="table table-bordered table-sm align-middle mb-3">
				<thead class="table-light">
				<tr>
					<th>Naam</th>
					<th>Omschrijving</th>
					<th>Volwassenen</th>
					<th>Kinderen</th>
					<th>Babys</th>
					<th>Vertegenwoordiger</th>
					<th class="text-center">Allergie Details</th>
				</tr>
				</thead>
				<tbody>
				@forelse($gezinnen as $gezin)
					<tr>
						<td>{{ $gezin->Naam }}</td>
						<td>{{ $gezin->Omschrijving }}</td>
						<td>{{ $gezin->AantalVolwassenen }}</td>
						<td>{{ $gezin->AantalKinderen }}</td>
						<td>{{ $gezin->AantalBabys }}</td>
						<td>{{ trim((string) $gezin->Vertegenwoordiger) }}</td>
						<td class="text-center">
							<a class="icon-link" href="{{ route('allergie.gezin.show', ['gezinId' => $gezin->GezinId]) }}" title="Bekijk details">&#128214;</a>
						</td>
					</tr>
				@empty
					@if(empty($showNoDataWarning))
						<tr>
							<td colspan="7" class="text-center text-muted">Geen gegevens beschikbaar</td>
						</tr>
					@endif
				@endforelse
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
