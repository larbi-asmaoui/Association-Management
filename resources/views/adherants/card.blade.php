<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Adherent Card</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }

        .card {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: none;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.15);
        }

        .card-img-top {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 15px;
        }
    </style>
</head>

<body>
    <div class="card">
        <h1>{{ asset('storage/' . $adherant->image) }}</h1>
        <img src="{{ asset('storage/' . $adherant->image) }}" alt="">
        <div class="card-body text-center">
            <h5 class="card-title">{{ $adherant->first_name }} {{ $adherant->last_name }}</h5>
            <p class="card-text">CIN: {{ $adherant->cin }}</p>
            <p class="card-text">Tel: {{ $adherant->tel }}</p>
            <p class="card-text">Email: {{ $adherant->email }}</p>
            <p class="card-text">Sexe: {{ $adherant->sexe }}</p>
            <p class="card-text">Date of Birth: {{ $adherant->date_of_birth }}</p>
            <p class="card-text">Address: {{ $adherant->address }}</p>
        </div>
    </div>
</body>

</html>