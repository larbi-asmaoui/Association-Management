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
    @if ($evenements)
        <table>
            <caption>مداخيل الأنشطة</caption>
            <thead>
                <tr>
                    <th>الوصف</th>
                    <th>المبلغ</th>
                    <th>الملاحظات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($evenements as $evenement)
                    <tr>
                        <td>{{ $evenement['title'] }}</td>
                        <td>{{ $evenement['revenue'] }}</td>
                        <td>{{ $evenement['description'] }}</td>
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
                @foreach ($revenues as $revenueType => $revenue)
                    <tr>
                        <td>{{ $revenueType }}</td>
                        <td>{{ $revenue['total'] }}</td>
                    </tr>
                @endforeach
            @endif

        </tbody>
    </table>
    <br><br>
    <p class="second_title">المصاريف</p>

    @if ($evenements)
        <table>
            <caption>مصاريف الأنشطة</caption>
            <thead>
                <tr>
                    <th>الوصف</th>
                    <th>المبلغ</th>
                    <th>الملاحظات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($evenements as $evenement)
                    <tr>
                        <td>{{ $evenement['title'] }}</td>
                        <td>{{ $evenement['depense'] }}</td>
                        <td>{{ $evenement['description'] }}</td>
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
                @foreach ($depenses as $depenseType => $depense)
                    <tr>
                        <td>{{ $depenseType }}</td>
                        <td>{{ $depense['total'] }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <div class="signature">
        <p>إمضاء الرئيس</p>
        <p></p>
        <p>إمضاء الأمين</p>
    </div>
</body>

</html>
