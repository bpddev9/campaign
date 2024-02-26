<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <center>
        @if (!is_null($resume))
            @if ($resume->file_ext == 'txt')
                <iframe src='{{ URL::to('storage/' . $resume->file_path) }}' width='100%'
                    height='900' frameborder='0'></iframe>
            @else
                <iframe src='https://view.officeapps.live.com/op/embed.aspx?src={{ URL::to('storage/' . $resume->file_path) }}' width='100%'
                    height='900' frameborder='0'></iframe>
            @endif
        @else
            <p>Resume Not Found</p>
        @endif
    </center>
</body>

</html>
