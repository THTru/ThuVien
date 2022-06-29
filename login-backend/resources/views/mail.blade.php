<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LibraryMail</title>
</head>
<body>
    Bạn đọc: {{ $tenbandoc }} - ID:{{ $id_bandoc }}<br>
    Ngày {{ $ngaymuon }} có mượn các quyển sách:
    @foreach ($chitietmuon as $chitiet)
        @if($chitiet->ngaytra == '1900-01-01')
            <p> ID:{{ $chitiet->sach->id }} - {{ $chitiet->sach->tensach }}</p>
        @endif
    @endforeach
    Bạn chưa thực hiện trả sách đúng hẹn là ngày {{ $ngayhen }}.<br>
    Mong bạn sớm thực hiện trả lại sách cho thư viện.<br>
    Xin cảm ơn!
</body>
</html>