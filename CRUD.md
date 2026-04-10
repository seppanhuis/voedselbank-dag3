# Laravel CRUD Handleiding (AI-proof, stap voor stap)

Doel van dit document:
- Je kunt dit bestand samen met een opdracht aan een AI geven.
- De AI moet hiermee een complete, nette en werkende CRUD bouwen in Laravel.
- Deze handleiding gebruikt testdata (geen data uit het voorbeeld van school).

## 1. Scope en uitgangspunten

We bouwen een simpele CRUD voor entiteit: Product.

Velden:
- id (primary key)
- naam (string, max 100)
- beschrijving (string, max 255)
- prijs (decimal 10,2)
- is_actief (boolean) !moet altijd
- opmerkingen (string, max 255) !moet altijd, maar mag null zijn
- created_at (datetime(6)) !moet altijd
- updated_at (datetime(6)) !moet altijd

Tech:
- Laravel (huidige versie van project)
- Blade views
- MySQL
- Bootstrap via npm
- Routes in routes/web.php

## 2. Wat de AI precies moet opleveren

De AI moet minimaal deze onderdelen maken of aanpassen:
- app/Http/Controllers/ProductController.php
- app/Models/Product.php
- resources/views/producten/index.blade.php
- resources/views/producten/create.blade.php
- resources/views/producten/edit.blade.php
- routes/web.php
- resources/css/app.css
- resources/js/app.js
- database/createscripts/01_create_database_and_tables.sql
- database/createscripts/02_seed_testdata.sql
- database/createscripts/sp_GetAllProducten.sql
- database/createscripts/sp_CreateProduct.sql
- database/createscripts/sp_DeleteProduct.sql
- database/createscripts/sp_GetProductById.sql
- database/createscripts/sp_UpdateProduct.sql

Daarnaast:
- Correcte validatie in store() en update()
- Succes- en foutmeldingen in index view
- Redirects na create, update en delete
- Werkende link vanaf homepage naar Producten

## 3. Setup en starten

1. Open project in VS Code.
2. Open terminal met Ctrl + `.
3. Start app met:

```bash
composer run dev
```

4. Installeer Bootstrap:

```bash
npm install bootstrap @popperjs/core
```

5. Voeg toe bovenaan resources/css/app.css:

```css
@import "bootstrap/dist/css/bootstrap.min.css";
```

6. Voeg in resources/js/app.js Bootstrap toe:

```js
import './bootstrap';
import * as bootstrap from 'bootstrap';

window.bootstrap = bootstrap;
```

## 4. Database scripts (testdata)

Maak map database/createscripts als die nog niet bestaat.

### 4.1 Bestand: 01_create_database_and_tables.sql

```sql
DROP DATABASE IF EXISTS `mvc_test_crud`;
CREATE DATABASE IF NOT EXISTS `mvc_test_crud`;
USE `mvc_test_crud`;

DROP TABLE IF EXISTS Product;

CREATE TABLE IF NOT EXISTS Product (
	Id TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
	Naam VARCHAR(100) NOT NULL,
	Beschrijving VARCHAR(255) NOT NULL,
	Prijs DECIMAL(10,2) NOT NULL,
	IsActief BIT NOT NULL DEFAULT 1,
	DatumAangemaakt DATETIME(6) NOT NULL,
	DatumGewijzigd DATETIME(6) NOT NULL,
	CONSTRAINT PK_Product_Id PRIMARY KEY (Id)
) ENGINE=InnoDB;
```

### 4.2 Bestand: 02_seed_testdata.sql

```sql
USE `mvc_test_crud`;

INSERT INTO Product
(
	Naam,
	Beschrijving,
	Prijs,
	IsActief,
	DatumAangemaakt,
	DatumGewijzigd
)
VALUES
	('Test Product A', 'Eerste testproduct', 9.95, 1, SYSDATE(6), SYSDATE(6)),
	('Test Product B', 'Tweede testproduct', 19.50, 1, SYSDATE(6), SYSDATE(6)),
	('Test Product C', 'Derde testproduct', 5.00, 1, SYSDATE(6), SYSDATE(6));
```

### 4.3 Stored procedure: sp_GetAllProducten.sql

```sql
DROP PROCEDURE IF EXISTS sp_GetAllProducten;

DELIMITER $$

CREATE PROCEDURE sp_GetAllProducten()
BEGIN
	SELECT
		P.Id,
		P.Naam,
		P.Beschrijving,
		P.Prijs,
		P.IsActief
	FROM Product AS P
	ORDER BY P.Id ASC;
END$$

DELIMITER ;
```

### 4.4 Stored procedure: sp_CreateProduct.sql

```sql
DROP PROCEDURE IF EXISTS sp_CreateProduct;

DELIMITER $$

CREATE PROCEDURE sp_CreateProduct(
	IN p_naam VARCHAR(100),
	IN p_beschrijving VARCHAR(255),
	IN p_prijs DECIMAL(10,2)
)
BEGIN
	INSERT INTO Product (
		Naam,
		Beschrijving,
		Prijs,
		IsActief,
		DatumAangemaakt,
		DatumGewijzigd
	)
	VALUES (
		p_naam,
		p_beschrijving,
		p_prijs,
		1,
		SYSDATE(6),
		SYSDATE(6)
	);

	SELECT LAST_INSERT_ID() AS new_id;
END$$

DELIMITER ;
```

### 4.5 Stored procedure: sp_DeleteProduct.sql

```sql
DROP PROCEDURE IF EXISTS sp_DeleteProduct;

DELIMITER $$

CREATE PROCEDURE sp_DeleteProduct(
	IN p_id INT
)
BEGIN
	DELETE FROM Product
	WHERE Id = p_id;

	SELECT ROW_COUNT() AS affected;
END$$

DELIMITER ;
```

### 4.6 Stored procedure: sp_GetProductById.sql

```sql
DROP PROCEDURE IF EXISTS sp_GetProductById;

DELIMITER $$

CREATE PROCEDURE sp_GetProductById(
	IN p_id INT
)
BEGIN
	SELECT
		P.Id,
		P.Naam,
		P.Beschrijving,
		P.Prijs,
		P.IsActief
	FROM Product AS P
	WHERE P.Id = p_id;
END$$

DELIMITER ;
```

### 4.7 Stored procedure: sp_UpdateProduct.sql

```sql
DROP PROCEDURE IF EXISTS sp_UpdateProduct;

DELIMITER $$

CREATE PROCEDURE sp_UpdateProduct(
	IN p_id INT,
	IN p_naam VARCHAR(100),
	IN p_beschrijving VARCHAR(255),
	IN p_prijs DECIMAL(10,2)
)
BEGIN
	UPDATE Product
	SET
		Naam = p_naam,
		Beschrijving = p_beschrijving,
		Prijs = p_prijs,
		DatumGewijzigd = SYSDATE(6)
	WHERE Id = p_id;

	SELECT ROW_COUNT() AS affected;
END$$

DELIMITER ;
```

Voer deze scripts uit in MySQL Workbench in deze volgorde:
1. 01_create_database_and_tables.sql
2. 02_seed_testdata.sql
3. Alle sp_*.sql bestanden

## 5. Laravel controller en model genereren

Gebruik artisan:

```bash
php artisan make:controller ProductController --resource --model=Product
```

Controleer dat deze bestanden bestaan:
- app/Http/Controllers/ProductController.php
- app/Models/Product.php

## 6. Routes toevoegen

Voeg in routes/web.php de volgende routes toe:

```php
use App\Http\Controllers\ProductController;

Route::get('/producten', [ProductController::class, 'index'])->name('producten.index');
Route::get('/producten/create', [ProductController::class, 'create'])->name('producten.create');
Route::post('/producten', [ProductController::class, 'store'])->name('producten.store');
Route::get('/producten/{id}/edit', [ProductController::class, 'edit'])->name('producten.edit');
Route::put('/producten/{id}', [ProductController::class, 'update'])->name('producten.update');
Route::delete('/producten/{id}', [ProductController::class, 'destroy'])->name('producten.destroy');
```

Voeg ook op homepage een link toe naar /producten.

## 7. Model implementatie (stored procedures)

Plaats in app/Models/Product.php:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
	public function sp_GetAllProducten()
	{
		return DB::select('CALL sp_GetAllProducten()');
	}

	public function sp_CreateProduct($naam, $beschrijving, $prijs)
	{
		$row = DB::selectOne(
			'CALL sp_CreateProduct(:naam, :beschrijving, :prijs)',
			[
				'naam' => $naam,
				'beschrijving' => $beschrijving,
				'prijs' => $prijs,
			]
		);

		return $row->new_id;
	}

	public function sp_DeleteProduct($id)
	{
		$row = DB::selectOne('CALL sp_DeleteProduct(:id)', ['id' => $id]);

		return $row->affected;
	}

	public function sp_GetProductById($id)
	{
		return DB::selectOne('CALL sp_GetProductById(:id)', ['id' => $id]);
	}

	public function sp_UpdateProduct($id, $naam, $beschrijving, $prijs)
	{
		$row = DB::selectOne(
			'CALL sp_UpdateProduct(:id, :naam, :beschrijving, :prijs)',
			[
				'id' => $id,
				'naam' => $naam,
				'beschrijving' => $beschrijving,
				'prijs' => $prijs,
			]
		);

		return $row->affected ?? 0;
	}
}
```

## 8. Controller implementatie

Plaats in app/Http/Controllers/ProductController.php:

```php
<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
	private $productModel;

	public function __construct()
	{
		$this->productModel = new Product();
	}

	public function index()
	{
		$producten = $this->productModel->sp_GetAllProducten();

		return view('producten.index', [
			'title' => 'Producten',
			'producten' => $producten,
		]);
	}

	public function create()
	{
		return view('producten.create', [
			'title' => 'Nieuw product toevoegen',
		]);
	}

	public function store(Request $request)
	{
		$data = $request->validate([
			'naam' => 'required|string|max:100',
			'beschrijving' => 'required|string|max:255',
			'prijs' => 'required|numeric|min:0',
		]);

		$newId = $this->productModel->sp_CreateProduct(
			$data['naam'],
			$data['beschrijving'],
			$data['prijs']
		);

		return redirect()->route('producten.index')
			->with('success', 'Product succesvol toegevoegd met id ' . $newId);
	}

	public function edit($id)
	{
		$product = $this->productModel->sp_GetProductById($id);
		abort_if(!$product, 404);

		return view('producten.edit', [
			'title' => 'Product wijzigen',
			'product' => $product,
		]);
	}

	public function update(Request $request, $id)
	{
		$data = $request->validate([
			'naam' => 'required|string|max:100',
			'beschrijving' => 'required|string|max:255',
			'prijs' => 'required|numeric|min:0',
		]);

		$result = $this->productModel->sp_UpdateProduct(
			$id,
			$data['naam'],
			$data['beschrijving'],
			$data['prijs']
		);

		if ($result > 0) {
			return redirect()->route('producten.index')
				->with('success', 'Product succesvol gewijzigd');
		}

		return back()->withInput()->with('error', 'Product is niet gewijzigd');
	}

	public function destroy($id)
	{
		$result = $this->productModel->sp_DeleteProduct($id);

		if ($result > 0) {
			return redirect()->route('producten.index')
				->with('success', 'Product succesvol verwijderd');
		}

		return redirect()->route('producten.index')
			->with('error', 'Product is niet verwijderd');
	}
}
```

## 9. Views maken

Maak map resources/views/producten en maak 3 bestanden.

### 9.1 index.blade.php

```php
@vite(['resources/css/app.css', 'resources/js/app.js'])
<!DOCTYPE html>
<html lang="nl">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{ $title }}</title>
</head>
<body class="bg-light">
	<div class="container py-5">
		<h1 class="mb-4">{{ $title }}</h1>

		@if (session('success'))
			<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
				{{ session('success') }}
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Sluiten"></button>
			</div>
			<meta http-equiv="refresh" content="3;url={{ route('producten.index') }}">
		@elseif (session('error'))
			<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
				{{ session('error') }}
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Sluiten"></button>
			</div>
			<meta http-equiv="refresh" content="3;url={{ route('producten.index') }}">
		@endif

		<a href="{{ route('producten.create') }}" class="btn btn-primary mb-3">Nieuw product</a>

		<div class="card shadow-sm">
			<div class="card-body p-0">
				<table class="table table-striped table-hover mb-0 align-middle">
					<thead class="table-light">
					<tr>
						<th>Naam</th>
						<th>Beschrijving</th>
						<th>Prijs</th>
						<th class="text-center">Verwijder</th>
						<th class="text-center">Wijzig</th>
					</tr>
				</thead>
				<tbody>
				@forelse ($producten as $product)
					<tr>
						<td>{{ $product->Naam }}</td>
						<td>{{ $product->Beschrijving }}</td>
						<td>EUR {{ number_format($product->Prijs, 2, ',', '.') }}</td>
						<td class="text-center">
							<form action="{{ route('producten.destroy', $product->Id) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je dit product wilt verwijderen?');">
								@csrf
								@method('DELETE')
								<button type="submit" class="btn btn-sm btn-danger">Verwijder</button>
							</form>
						</td>
						<td class="text-center">
							<form action="{{ route('producten.edit', $product->Id) }}" method="GET">
								<button type="submit" class="btn btn-sm btn-success">Wijzig</button>
							</form>
						</td>
					</tr>
				@empty
					<tr>
						<td colspan="5" class="text-center text-muted py-4">Geen producten beschikbaar</td>
					</tr>
				@endforelse
				</tbody>
			</table>
			</div>
		</div>
	</div>
</body>
</html>
```

### 9.2 create.blade.php

```php
@vite(['resources/css/app.css', 'resources/js/app.js'])
<!DOCTYPE html>
<html lang="nl">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{ $title }}</title>
</head>
<body class="bg-light">
	<div class="container py-5" style="max-width: 720px;">
		<h2 class="mb-4">{{ $title }}</h2>

		@if ($errors->any())
			<div class="alert alert-danger">
				<ul class="mb-0">
					@foreach ($errors->all() as $err)
						<li>{{ $err }}</li>
					@endforeach
				</ul>
			</div>
		@endif

		<form method="POST" action="{{ route('producten.store') }}" class="card card-body shadow-sm">
			@csrf

			<div class="mb-3">
				<label for="naam" class="form-label">Naam</label>
				<input type="text" id="naam" name="naam" class="form-control" value="{{ old('naam') }}" required>
			</div>

			<div class="mb-3">
				<label for="beschrijving" class="form-label">Beschrijving</label>
				<input type="text" id="beschrijving" name="beschrijving" class="form-control" value="{{ old('beschrijving') }}" required>
			</div>

			<div class="mb-3">
				<label for="prijs" class="form-label">Prijs</label>
				<input type="number" step="0.01" min="0" id="prijs" name="prijs" class="form-control" value="{{ old('prijs') }}" required>
			</div>

			<div class="d-flex gap-2">
				<button type="submit" class="btn btn-primary">Opslaan</button>
				<a href="{{ route('producten.index') }}" class="btn btn-secondary">Annuleren</a>
			</div>
		</form>
	</div>
</body>
</html>
```

### 9.3 edit.blade.php

```php
@vite(['resources/css/app.css', 'resources/js/app.js'])
<!DOCTYPE html>
<html lang="nl">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{ $title }}</title>
</head>
<body class="bg-light">
	<div class="container py-5" style="max-width: 720px;">
		<h2 class="mb-4">{{ $title }}</h2>

		@if ($errors->any())
			<div class="alert alert-danger">
				<ul class="mb-0">
					@foreach ($errors->all() as $err)
						<li>{{ $err }}</li>
					@endforeach
				</ul>
			</div>
		@endif

		<form method="POST" action="{{ route('producten.update', $product->Id) }}" class="card card-body shadow-sm">
			@csrf
			@method('PUT')

			<div class="mb-3">
				<label for="naam" class="form-label">Naam</label>
				<input type="text" id="naam" name="naam" class="form-control"
					   value="{{ old('naam', $product->Naam) }}" required>
			</div>

			<div class="mb-3">
				<label for="beschrijving" class="form-label">Beschrijving</label>
				<input type="text" id="beschrijving" name="beschrijving" class="form-control"
					   value="{{ old('beschrijving', $product->Beschrijving) }}" required>
			</div>

			<div class="mb-3">
				<label for="prijs" class="form-label">Prijs</label>
				<input type="number" step="0.01" min="0" id="prijs" name="prijs" class="form-control"
					   value="{{ old('prijs', $product->Prijs) }}" required>
			</div>

			<div class="d-flex gap-2">
				<button type="submit" class="btn btn-primary">Opslaan</button>
				<a href="{{ route('producten.index') }}" class="btn btn-secondary">Annuleren</a>
			</div>
		</form>
	</div>
</body>
</html>
```

## 10. Prompt-template die je aan AI kunt geven

Kopieer dit blok en vul alleen project-specifieke details in:

```text
Bouw een volledige Laravel CRUD voor entiteit Product met Blade en MySQL stored procedures.

Eisen:
1. Gebruik routes:
   - GET /producten (index)
   - GET /producten/create (create)
   - POST /producten (store)
   - GET /producten/{id}/edit (edit)
   - PUT /producten/{id} (update)
   - DELETE /producten/{id} (destroy)
2. Gebruik modelmethodes die stored procedures aanroepen met named binding.
3. Gebruik validatie in store en update.
4. Gebruik @csrf in alle forms.
5. Gebruik @method('PUT') en @method('DELETE') waar nodig.
6. Bouw views:
   - resources/views/producten/index.blade.php
   - resources/views/producten/create.blade.php
   - resources/views/producten/edit.blade.php
7. Toon success/error meldingen in index met Bootstrap-styling.
8. Voeg Bootstrap toe via npm en importeer het in app.css. Laad Bootstrap ook in app.js.
9. Lever SQL scripts voor:
   - database + tabel
   - seed testdata
   - sp_GetAllProducten
   - sp_CreateProduct
   - sp_DeleteProduct
   - sp_GetProductById
   - sp_UpdateProduct
10. Houd code PSR-12 stijl aan en wijzig alleen noodzakelijke bestanden.

Geef als output:
- Een kort overzicht van gewijzigde bestanden
- Volledige code per bestand
- Korte teststappen om handmatig te controleren dat CRUD werkt
```

## 11. Handmatige test-checklist

1. Open homepage en klik op link Producten.
2. Controleer of lijst met testdata zichtbaar is.
3. Klik op Nieuw product, vul formulier in, sla op.
4. Controleer successmelding en nieuw record in tabel.
5. Klik op Wijzig, pas velden aan, sla op.
6. Controleer of wijzigingen zichtbaar zijn.
7. Klik op Verwijder, bevestig popup.
8. Controleer of record weg is en successmelding zichtbaar is.

Als alle stappen slagen, is de CRUD correct gebouwd.

## 12. belangrijke extra's om toe te voegen

1. joins
2. try catch
3. stored procedures
4. passende naamgeving
5. technische log
6. duidelijke terugkoppeling
7. responzive
