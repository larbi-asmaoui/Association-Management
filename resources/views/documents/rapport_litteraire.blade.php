<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Rapport litteraire</title>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #000;
            text-align: center;
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

        .signature {
            width: 100%;
        }
    </style>
</head>

<body style="font-family: DejaVu Sans; direction: rtl;">
    @php
        $yearPlural = $association->date_creation ? (new DateTime($association->date_creation))->diff(new DateTime())->y + 1 : 0;
        $yearPhrase = '';

        if ($yearPlural <= 1) {
            $yearPhrase = 'سنة';
        } elseif ($yearPlural == 2) {
            $yearPhrase = 'سنتين';
        } elseif ($yearPlural > 2 && $yearPlural <= 10) {
            $yearPhrase = $yearPlural . ' سنوات';
        } elseif ($yearPlural > 10) {
            $yearPhrase = $yearPlural . ' سنة';
        }

    @endphp

    <div>

        <p class="name">{{ $association->name }}</p>
        <p class="title">التقرير الأدبي للجمعية : {{ $season }}</p>
        <p>لقد قطعت {{ $association->name ?? 'null' }} أشواطا مهمة خلال مدة لا تتعدى
            {{ $yearPhrase }} من عمر
            هذه الجمعية، فقد تأسست جمعيتنا تحت اسم: {{ $association->name ?? 'null' }} بتاريخ
            {{ date_format(new DateTime($association->date_creation), 'Y/m/d') }}،
            ومنذ ذلك التاريخ وهي
            تحاول تحقيق الأهداف المتوخاة والمسطرة في القانون الأساسي للجمعية، فطبقا للمادة السابعة من القانون الأساسي
            للجمعية فإنها تعقد جمعا سنويا لتقييم نشاطها ووضع برنامج للسنة التالية، وهكذا قامت الجمعية بمجموعة من الأنشطة
            بمبادرات فردية وتضحيات من طرف كافة العضوات والمنخرطات ونذكرها كما يلـــي:
        </p>

        <table>
            <thead>
                <tr>
                    <th>المرجع</th>
                    <th>النشاط</th>
                    {{-- <th>الوصف</th> --}}
                    <th>تاريخ البدء</th>
                    <th>تاريخ النهاية</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($evenements as $evenement)
                    <tr>
                        <td>{{ $evenement['reference'] }}</td>
                        <td>{{ $evenement['title'] }}</td>
                        {{-- <td>{{ $evenement['description'] ?? '-' }}</td> --}}
                        {{-- <td>{{ $evenement['evenement_type']['name'] }}</td> --}}
                        <td>{{ $evenement['start'] }}</td>
                        <td>{{ $evenement['end'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="clear: both;overflow: hidden;width: 600px; margin:auto;margin-top:50px;">
            <p align="left" style="width: 50%;float: left;margin-top:20px;">إمضاء الكاتب</p>
            <p align="right" style="width: 50%;float: left;">إمضاء الرئيس</p>
        </div>


    </div>
</body>

</html>
