<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</title>
</head>
<body link="blue">
<div>
    <table border="0" cellspacing="0" cellpadding="0" width="600" style="border-collapse:collapse">
        <tr style="height:1.0in">
            <td width="200" colspan="2" valign="top">
                <h2> đề thi</h2>
            </td>
            <td width="400" colspan="2" valign="top" style="padding:0;height:1.0in;text-align: center;"></td>
        </tr>
    </table>

    <p align="center" style="text-align:center;text-indent:.5in"><b><span style="color:black">ĐIỀU KHOẢN CỤ THỂ CỦA HỢP ĐỒNG</span></b></p>

    @if(!empty($questions))
        <?php $number = 1;?>
        @foreach($questions as $key => $ques)
            <br/><br/> <b>Câu {{$number}}: </b>{{$ques['question_name']}}
                <?php $number_answer = 1;?>
            @foreach($ques['list_answer'] as $kk => $answer)
                <br/>&nbsp;&nbsp;&nbsp;<b>{{$list_dap_an[$number_answer]}}: </b>{{$answer}}
                <?php $number_answer++;?>
            @endforeach
            <?php $number++;?>
        @endforeach
    @endif
</div>
</body>
</html>
