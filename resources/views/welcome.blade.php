@vite(['resources/css/app.css', 'resources/js/app.js'])
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage voedselbank maaskantje</title>
</head>
<body>
<div class="container py-4">
    <div class="wireframe-card p-4 p-md-5" style="max-width: 560px;">
        <h1 class="h1 mb-3" style="font-weight: 500;">Homepage voedselbank maaskantje</h1>
        <a href="{{ route('allergie.index') }}">Overzicht gezinsallergie&euml;n</a>
    </div>
</div>
</body>
</html>
