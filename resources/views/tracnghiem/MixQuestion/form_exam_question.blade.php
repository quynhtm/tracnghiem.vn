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
    <p style="width: 100%; text-align: center">Họ và tên thí sinh:......................................................................................................Lớp:...............<br><b>______________________________________________________________________________</b></p>
    <br>
    @if(!empty($questions))
        <?php $number = 1;?>
        @foreach($questions as $key => $ques)
            <b>Câu {{$number}}: </b>{{$ques['question_name']}}
            <?php $number_answer = 1;?>
                @foreach($ques['list_answer'] as $kk => $answer)
                    <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="col-lg-6"><b>{{$list_dap_an[$number_answer]}}: </b>{{$answer}}</span>
                    <?php $number_answer++;?>
                @endforeach
            <br/><br/>
            <?php $number++;?>
        @endforeach
    @endif
</div>
</body>
</html>
