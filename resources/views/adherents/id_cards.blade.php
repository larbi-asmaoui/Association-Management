<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>cartes</title>
    <style>
        .page {
            width: 21cm;
            height: 29.7cm;
            /* A4 size in centimeters */
            padding: 1cm;
            position: relative;
        }

        .id-card {
            width: 10.5cm;
            /* Half of A4 width */
            height: 9.9cm;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin: 5px;
            display: inline-block;
            background-color: #f0f8ff;
            /* Light blue background color */
            position: relative;
        }

        /*  */

        .id-card img {
            max-width: 100%;
            height: auto;
            border-radius: 50%;
            /* Makes the image circular */
            border: 3px solid white;
            /* Add a white border to the image */
            object-fit: cover;
            /* Ensure the image covers the circular space */
        }



        .adherent-name {
            font-size: 16px;
            font-weight: bold;
            margin: 5px 0;
        }

        .adherent-id {
            font-size: 14px;
        }
    </style>
</head>

<body>
    @foreach ($adherents as $key => $adherent)
        @if ($key % 2 === 0)
            <div class="page">
        @endif

        <div class="id-card">
            <img src="{{ $adherent->image }}" alt="adherent Photo">
            <p class="adherent-name">{{ $adherent->first_name }}</p>
            <p class="adherent-id">ID: {{ $adherent->id }}</p>
            <!-- Add more card details as needed -->
        </div>

        @if (($key + 1) % 2 === 0 || $key + 1 === count($adherents))
            <div class="id-card"></div>
        @endif

        @if ($key % 4 === 0 || $key + 1 === count($adherents))
            </div>
        @endif
    @endforeach
</body>

</html>
