<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>BỘ GIÁO DỤC VÀ ĐÀO TẠO</title>
</head>
<body link="blue">
<div>
    <table border="0" cellspacing="0" cellpadding="0" width="600" style="border-collapse:collapse">
        <tr style="height:0.5in;text-align: center!important;">
            <td width="200" colspan="2" valign="top" style="padding:0;text-align: center;" class="text-center">
                <br>
                <b>PHÒNG GD&ĐT</b><br>
                <b>Mã đề {{$id_de_thi}}</b><br>
                <i>( {{$total_question}} câu hỏi )</i>
            </td>
            <td width="400" colspan="2" valign="top" style="padding:0;text-align: center;" class="text-center">
                <b>{{$ten_de_thi}}</b><br>
                Năm học: <b>{{$nam_hoc}}</b><br>
                Môn thi: <b>{{$ten_mon_hoc}}</b> - Khối: <b>{{$ten_khoi_lop}}</b><br>
                Chuyên đề: <b>{{$ten_chuyen_de}}</b><br>
                <i>Thời gian làm bài : {{$time_to_do}} phút <br>
                    (không kể thời gian phát đề)
                </i>
            </td>
        </tr>
    </table>
    <h2 style="width: 100%; text-align: center">Đáp án của Mã đề {{$id_de_thi}}</h2>
    <br>
    @if(!empty($list_answer_true))
        @foreach($list_answer_true as $number => $answer)
            Câu {{$number}}: <b>{{$answer}}</b>
            @if($number < 10)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            @else &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            @endif
            @if($number%5 == 0)<br>@endif
        @endforeach
    @endif
</div>
</body>
</html>
