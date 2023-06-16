<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Rapport litteraire</title>
    {{-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> --}}
    <style>
        body {
            direction: rtl !important;
        }
    </style>
</head>

<body>
    <div>
        hello
        {{ $association }}
        {{-- <h1>{{ $association->name }}</h1> --}}
        <p>لقد قطعت { association-> name } أشواطا مهمة خلال مدة وجيزة وقصيرة لا تتعدى سنة واحدة من عمر
            هذه الجمعية، فقد تأسست جمعيتنا تحت اسم: الجمعية النسوية لتربية النحل بتاريخ { $association->created_at }،
            ومنذ ذلك التاريخ وهي
            تحاول تحقيق الأهداف المتوخاة والمسطرة في القانون الأساسي للجمعية، فطبقا للمادة السابعة من القانون الأساسي
            للجمعية فإنها تعقد جمعا سنويا لتقييم نشاطها ووضع برنامج للسنة التالية، وهكذا قامت الجمعية بمجموعة من الأنشطة
            بمبادرات فردية وتضحيات من طرف كافة العضوات والمنخرطات ونذكرها كما يلـــي:</p>
    </div>
</body>

</html>
