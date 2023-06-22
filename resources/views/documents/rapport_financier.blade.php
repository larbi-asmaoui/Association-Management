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
            margin-bottom: 20px;
            font-size: 22px;
        }

        .title {
            font-size: 18px;
            text-align: center;
            margin-bottom: 30px;
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
    <p class="title">التقرير المالي للجمعية لموسم</p>
    <br>
    <p class="second_title">المداخيل</p>
    <table>
        <caption>مداخيل الأنشطة</caption>
        <thead>
            <tr>
                <th>الوصف</th>
                <th>المبلغ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($evenements as $evenementType => $evenement)
                <tr>
                    <td>{{ $evenementType }}</td>
                    <td>{{ $evenement['totalRevenue'] }}</td>
                </tr>
            @endforeach

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
            @foreach ($revenues as $revenueType => $revenue)
                <tr>
                    <td>{{ $revenueType }}</td>
                    <td>{{ $revenue['total'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br><br>
    <p class="second_title">المصاريف</p>

    <table>
        <caption>مصاريف الأنشطة</caption>
        <thead>
            <tr>
                <th>الوصف</th>
                <th>المبلغ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($evenements as $evenementType => $evenement)
                <tr>
                    <td>{{ $evenementType }}</td>
                    <td>{{ $evenement['totalDepense'] }}</td>
                </tr>
            @endforeach

    </table>
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
            @foreach ($depenses as $depenseType => $depense)
                <tr>
                    <td>{{ $depenseType }}</td>
                    <td>{{ $depense['total'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="signature">
        <p>إمضاء الرئيس</p>
        <p></p>
        <p>إمضاء الأمين</p>
    </div>
</body>

</html>
