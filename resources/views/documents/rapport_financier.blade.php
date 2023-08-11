<!DOCTYPE html>
<html dir="rtl">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Rapport Financier</title>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #000;
            text-align: right;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }

        .name {
            text-align: center;
            margin-bottom: 10px;
            font-size: 22px;
        }

        .title {
            font-size: 18px;
            text-align: center;
            margin-bottom: 20px;
        }

        .second_title {
            font-size: 18px;
            text-align: center;
            margin-bottom: 10px;
            text-decoration: underline;
            font-weight: bold;
        }

        .signature {
            margin: auto;
            text-align: center
        }

        .signature p {
            margin-top: 80px;
        }
    </style>
</head>

<body style="font-family: DejaVu Sans; direction: rtl;">
    <p class="name">{{ $association[0]->name }}</p>
    <p class="title">التقرير المالي للجمعية لموسم : {{ $season }}</p>
    <br>
    <p class="second_title">المداخيل</p>
    @if ($evenements)
        <table>
            <caption>مداخيل الأنشطة</caption>
            <thead>
                <tr>
                    <th>الوصف</th>
                    <th>المبلغ</th>
                    {{-- <th>الملاحظات</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($evenements as $evenement)
                    <tr>
                        <td>{{ $evenement['title'] }}</td>
                        <td>{{ $evenement['revenue'] }}</td>
                        {{-- <td>{{ $evenement['description'] }}</td> --}}
                    </tr>
                @endforeach

        </table>
    @endif
    <br>
    <table style="width:100%">
        <caption>الانخراطات</caption>
        <thead>
            <tr>
                <th>الانخراطات</th>
                <th>{{ $frais_adhesions }} درهم</th>

            </tr>
        </thead>
    </table>
    <br>
    <table>
        <caption>مداخيل أخرى</caption>
        <thead>
            <tr>
                <th>الوصف</th>
                <th>المبلغ</th>
            </tr>
        </thead>
        <tbody>
            @if ($revenues)
                @foreach ($revenues as $revenue)
                    <tr>
                        <td>{{ $revenue['titre'] }}</td>
                        <td>{{ $revenue['montant'] }}</td>
                    </tr>
                @endforeach
            @endif

        </tbody>
    </table>
    <br>
    <p class="second_title">المصاريف</p>

    @if ($evenements)
        <table>
            <caption>مصاريف الأنشطة</caption>
            <thead>
                <tr>
                    <th>الوصف</th>
                    <th>المبلغ</th>
                    {{-- <th>الملاحظات</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($evenements as $evenement)
                    <tr>
                        <td>{{ $evenement['title'] }}</td>
                        <td>{{ $evenement['depense'] }}</td>
                        {{-- <td>{{ $evenement['description'] }}</td> --}}
                    </tr>
                @endforeach

        </table>
    @endif
    <br>
    <table>
        <caption>مصاريف أخرى</caption>
        <thead>
            <tr>
                <th>الوصف</th>
                <th>المبلغ</th>
            </tr>
        </thead>
        <tbody>
            @if ($depenses)
                @foreach ($depenses as $depense)
                    <tr>
                        <td>{{ $depense['titre'] }}</td>
                        <td>{{ $depense['montant'] }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <br>
    <table style="width:100%">
        <caption>الممتلكات</caption>
        <thead>
            <tr>
                <th>الممتلكات</th>
                <th>{{ $totalStock }} درهم</th>

            </tr>
        </thead>
    </table>
    <br><br>
    <p>مجموع المداخيل: {{ $totalRevenus }} درهم</p>
    <p>مجموع المصـاريف: {{ $totalDepenses }} درهم</p>
    <p>الميزانية:
        {{ $totalRevenus - $totalDepenses < 0 ? abs($totalRevenus - $totalDepenses) . '-' : abs($totalRevenus - $totalDepenses) . '+' }}
        درهم (العجز او الفائض).</p>

    <br>

    <div style="clear: both;overflow: hidden;width: 600px; margin:auto;margin-top:50px;">
        <p align="left" style="width: 50%;float: left;margin-top:20px;">إمضاء الأمين</p>
        <p align="right" style="width: 50%;float: left;">إمضاء الرئيس</p>
    </div>

</body>

</html>
