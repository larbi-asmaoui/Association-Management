<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Rapport litteraire</title>
    <style>
        * {
            font-family: DejaVu Sans, sans-serif;
        }



        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #000;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        h2 {
            font-size: 18px;
            text-align: center;
            margin-bottom: 30px;
        }
    </style>
</head>

<body style="font-family: DejaVu Sans; direction: rtl;">
    <div>
        <h1>{{ $association[0]->name }}</h1>
        <h2>التقرير الأدبي للجمعية</h2>
        <p>لقد قطعت {{ $association[0]->name }} أشواطا مهمة خلال مدة وجيزة وقصيرة لا تتعدى سنة واحدة من عمر
            هذه الجمعية، فقد تأسست جمعيتنا تحت اسم: الجمعية النسوية لتربية النحل بتاريخ
            {{ $association[0]->created_at }}،
            ومنذ ذلك التاريخ وهي
            تحاول تحقيق الأهداف المتوخاة والمسطرة في القانون الأساسي للجمعية، فطبقا للمادة السابعة من القانون الأساسي
            للجمعية فإنها تعقد جمعا سنويا لتقييم نشاطها ووضع برنامج للسنة التالية، وهكذا قامت الجمعية بمجموعة من الأنشطة
            بمبادرات فردية وتضحيات من طرف كافة العضوات والمنخرطات ونذكرها كما يلـــي:
        </p>

        <table>
            <thead>
                <tr>
                    <th>Evenement</th>
                    <th>Description</th>
                    <th>type</th>
                    <th>Date de debut</th>
                    <th>Date de fin</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($evenements as $evenement)
                    <tr>
                        <td>{{ $evenement['title'] }}</td>
                        <td>{{ $evenement['description'] }}</td>
                        <td>{{ $evenement['evenement_type']['name'] }}</td>
                        <td>{{ $evenement['start'] }}</td>
                        <td>{{ $evenement['end'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
