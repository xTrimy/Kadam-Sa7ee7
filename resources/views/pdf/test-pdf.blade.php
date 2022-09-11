<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Document</title>
    <style>
        @font-face {
            font-family: "Somar";
            src: url("{{ public_path('fonts/Somar-Bold.otf') }}");
        }
        .page-break {
            page-break-after: always;
        }
        .pagenum:before {
            content: counter(page);
        }
        body{
            font-family: "Cairo" !important;
            font-weight: bold !important;
        }
        @page { 
            font-family: "Cairo" !important;
            font-weight: bold !important;
            background-image: url("{{ public_path('images/pattern.jpg') }}");
            background-image-resize:6;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            margin: 180px 50px;
            header: page-header;
	        footer: page-footer;
        }
        body {background-image:url({{ public_path('images/pattern.jpg') }}); background-image-resize:6}
             tr:nth-child(even) {
                background-color: rgba(0,0,0,0.1);
             }
    </style>
</head>
<body style="font-family:'Cairo';" class="mx-8" dir="rtl">
    
    <htmlpageheader name="page-header">
        <div style="float: left; text-align:left; width: 25%;">
            <img style="width:100px; height:100px;" class=" object-contain object-center" src="{{ public_path('images/s.png') }}" alt="">
        </div>
        <div style="float:right; margin-left: 35%; width: 65%; ">
            <img style="width:100px; height:100px;" class=" object-contain object-center" src="{{ public_path('images/Layer 1.png') }}" alt="">
        </div>
    </htmlpageheader>
    <main>
    <table class="w-full px-8 border-collapse border border-solid border-slate-500">
        <thead>
            <tr class="">
                <th style="background-color:yellow" class="border border-solid  border-slate-600 text-right ">م</th>
                <th style="background-color:yellow" class="border border-solid  border-slate-600 text-right ">الأسم</th>
                <th style="background-color:yellow" class="border border-solid  border-slate-600 text-right ">الرقم القومي</th>
                <th style="background-color:yellow" class="border border-solid  border-slate-600 text-right ">القرية / المركز</th>
                <th style="background-color:yellow" class="border border-solid  border-slate-600 text-right ">المحافظة</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $key => $item)
                <tr>
                    <td style="background-color:yellow" class="border border-solid  border-slate-600">{{ $item[0] }}</td>
                    <td class="border border-solid border-slate-600">{{ $item[1] }}</td>
                    <td style="margin-left:5px font-size:13px;" class="border ml-8 border-solid border-slate-600">{{ $item[2] }}</td>
                    <td class="border border-solid border-slate-600">{{ $item[3] }}</td>
                    <td class="border border-solid border-slate-600">{{ $item[4] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </main>
</body>
</html>