<div id="home" class="tab-pane fade in active">
    <div class="row">
        <div class="col-lg-12">
            <h3><b>{{viewLanguage('Khoản vay và thời gian')}}</b></h3>
            @if($id==0)
                <input type = "hidden" name="status" value="{{STATUS_NEW}}">
            @endif
            <div class="row marginTop10 ">
                <div class="col-lg-3 " >
                    <label for="name" class="text-bold" >{{viewLanguage('Số tiền vay min (VNĐ)')}}<span class="red"> (*) </span></label>
                    <input type="text" class="form-control paddingTopBottom text-right format_money padding-input" id="min_amount" name="min_amount"  value="@if(isset($data['min_amount'])){{($data['min_amount'])}}@endif" required>
                </div>
                {{--<div class="col-lg-2"></div>--}}
                <div class="col-lg-3">
                    <label for="name" class="text-bold">{{viewLanguage('Số tiền vay max (VNĐ)')}}<span class="red"> (*) </span></label>
                    <input type="text" class="form-control paddingTopBottom text-right format_money padding-input" id="max_amount" name="max_amount" value="@if(isset($data['max_amount'])){{($data['max_amount'])}}@endif" required>
                </div>
                <div class="col-lg-3 " >
                    <label for="name" class="text-bold" >{{viewLanguage('Đơn vị tiền tệ')}}</label>
                    <select class="form-control" id="type_of_currency" name = "type_of_currency">
                        {!! $optionTypeCurrency !!}
                    </select>
                </div>
                <div class="clearfix"></div>
                <div class="col-lg-3 marginTop20" >
                    <label for="name" class="text-bold" >{{viewLanguage('Số ngày vay min (Ngày)')}}<span class="red"> (*) </span></label>
                    <input type="text" class="form-control paddingTopBottom text-right format_money padding-input" id="min_duration" name="min_duration"  value="@if(isset($data['min_duration'])){{$data['min_duration']}}@endif" required>
                </div>
                {{--<div class="col-lg-2"></div>--}}
                <div class="col-lg-3 marginTop20">
                    <label for="name" class="text-bold">{{viewLanguage('Số ngày vay max (Ngày)')}}<span class="red"> (*) </span></label>
                    <input type="text" class="form-control paddingTopBottom text-right format_money padding-input" id="max_duration" name="max_duration" value="@if(isset($data['max_duration'])){{numberFormat($data['max_duration'])}}@endif" required>
                </div>
                <div class="col-lg-3 marginTop20" >
                    <label for="name" class="text-bold" >{{viewLanguage('Đơn vị ngày vay')}}</label>
                    <select class="form-control" id="type_duration" name = "type_duration">
                        {!! $optionTypeDuration !!}
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="col-lg-6 row">
                <h3 ><b>{{viewLanguage('Thời gian hiệu lực')}}</b></h3>
                <div class="row marginTop10 ">
                    <div class="col-lg-6 " >
                        <label for="name" class="text-bold" >{{viewLanguage('Từ ngày')}}</label>
                        <input type="date" class="form-control paddingTopBottom" id="date_start_apply" name="date_start_apply"  value="@if(isset($data['date_start_apply'])){{date('Y-m-d',strtotime($data['date_start_apply']))}}@else{{date('Y-m-d')}}@endif">
                    </div>
                    {{--<div class="col-lg-2"></div>--}}
                    <div class="col-lg-6">
                        <label for="name" class="text-bold">{{viewLanguage('Đến ngày')}}</label>
                        <input type="date" class="form-control paddingTopBottom" id="date_end_end" name="date_end_end" value="@if(isset($data['date_end_end'])){{date('Y-m-d',strtotime($data['date_end_end']))}}@else{{date('Y-m-d')}}@endif">
                    </div>

                </div>
            </div>
            <div class="col-lg-6" style="margin-left: 20px">
                <h3 ><b>{{viewLanguage('Mobile app')}}</b></h3>
                <div class="row marginTop10 ">
                    <div class="col-lg-6 " >
                        <label for="name" class="text-bold" >{{viewLanguage('Số mốc')}}</label>
                        <input type="text" class="form-control paddingTopBottom" id="step_amount" name = "step_amount" value="@if(isset($data['step_amount'])){{$data['step_amount']}}@endif" required>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="row marginTop20">
        <div class="col-lg-12">
            <h3 ><b>{{viewLanguage('Hiển thị hạn mức vay')}}</b></h3>
            <div class="row marginTop10 ">
                <div class="col-lg-3 " >
                    <label for="name" class="text-bold" >{{viewLanguage('Hiển thị hạn mức vay mới')}}</label>
                    <textarea class="form-control paddingTopBottom" id="content_amount_new" name = "content_amount_new" value="@if(isset($data['content_amount_new'])){{$data['content_amount_new']}}@endif" required></textarea>
                </div>
                <div class="col-lg-3 " >
                    <label for="name" class="text-bold" >{{viewLanguage('Hiển thị hạn mức vay lại')}}</label>
                    <textarea class="form-control paddingTopBottom" id="content_amount_old" name = "content_amount_old" value="@if(isset($data['content_amount_old'])){{$data['content_amount_old']}}@endif" required></textarea>
                </div>
                <div class="col-lg-3 " >
                    <label for="status_content" class="text-bold" >{{viewLanguage('Trạng thái hiển thị')}}</label>
                    <select class="form-control" id="status_content" name = "status_content">
                        {!! $optionStatusContent !!}
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{--<div class="marginTop30"></div>--}}
</div>
